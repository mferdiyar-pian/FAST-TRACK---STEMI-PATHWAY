<?php
// app/Http/Controllers/CodeStemiController.php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataNakes;
use Carbon\Carbon;
use App\Events\CodeStemiStatusUpdated;
use App\Exports\CodeStemiExport;
use Maatwebsite\Excel\Facades\Excel;

class CodeStemiController extends Controller
{
    /**
     * Tampilkan halaman utama Code STEMI dengan filter.
     */
    public function index(Request $request)
    {
        $query = CodeStemi::query();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal spesifik
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('start_time', $request->date);
        }
        
        // Filter berdasarkan checklist
        if ($request->has('checklist_filter') && !empty($request->checklist_filter)) {
            $query->where(function($q) use ($request) {
                foreach ($request->checklist_filter as $checklistItem) {
                    $q->whereJsonContains('checklist', $checklistItem);
                }
            });
        }
        
        // Filter berdasarkan pencarian yang lebih komprehensif
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('medical_record_number', 'like', "%{$search}%")
                  ->orWhere('custom_message', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('duration', 'like', "%{$search}%")
                  ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(checklist, "$")) LIKE ?', ["%{$search}%"])
                  ->orWhereDate('start_time', 'like', "%{$search}%")
                  ->orWhereDate('end_time', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('start_time', 'desc')->paginate(10);
        
        // Tambahkan formatted_date dan door_to_balloon_time untuk setiap item
        $data->getCollection()->transform(function ($item) {
            $item->formatted_date = $item->start_time->setTimezone('Asia/Makassar')->format('d M, Y');
            $item->door_to_balloon_time = $this->calculateDoorToBalloonTime($item);
            return $item;
        });
        
        return view('code-stemi.index', compact('data'));
    }

    /**
     * Hitung door to balloon time
     */
    private function calculateDoorToBalloonTime($codeStemi)
    {
        if ($codeStemi->status === 'Finished' && $codeStemi->start_time && $codeStemi->end_time) {
            $start = Carbon::parse($codeStemi->start_time)->setTimezone('Asia/Makassar');
            $end = Carbon::parse($codeStemi->end_time)->setTimezone('Asia/Makassar');
            $diff = $end->diff($start);
            
            return sprintf('%02dh : %02dm : %02ds', $diff->h, $diff->i, $diff->s);
        } elseif ($codeStemi->status === 'Running' && $codeStemi->start_time) {
            $start = Carbon::parse($codeStemi->start_time)->setTimezone('Asia/Makassar');
            $now = now()->setTimezone('Asia/Makassar');
            $diff = $now->diff($start);
            
            return sprintf('%02dh : %02dm : %02ds', $diff->h, $diff->i, $diff->s);
        }
        
        return '00h : 00m : 00s';
    }

    /**
     * Aktivasi Code STEMI — kirim broadcast WA & catat waktu mulai.
     */
    public function store(Request $request)
    {
        $request->validate([
            'medical_record_number' => 'required|string|max:255',
            'checklist' => 'nullable|array',
            'checklist.*' => 'string',
            'custom_message' => 'nullable|string|max:500'
        ]);

        try {
            // Ambil semua staf aktif dari tabel data_nakes
            $staffs = DataNakes::where('aktif', true)->get();

            if ($staffs->isEmpty()) {
                return back()->with('error', 'Tidak ada staf aktif untuk dikirimi notifikasi.');
            }

            // Pesan broadcast dasar
            $baseMessage = "🚨 *CODE STEMI AKTIF!*\n\n" .
                          "No. Rekam Medis: *" . $request->medical_record_number . "*\n\n" .
                          "Pasien STEMI telah teridentifikasi di IGD RS Otak M Hatta Bukittinggi.\n" .
                          "Seluruh tim Cath Lab dan unit terkait harap bersiaga.\n\n" .
                          "Fast Track STEMI Pathway aktif.\n" .
                          "🕒 Waktu Door-to-Balloon dimulai.";

            // Tambahkan custom message jika ada
            $message = $baseMessage;
            if ($request->filled('custom_message')) {
                $message .= "\n\n" . $request->custom_message;
            }

            $successCount = 0;
            $failedNumbers = [];

            // Kirim pesan ke setiap staf
            foreach ($staffs as $staff) {
                if ($staff->contact) {
                    try {
                        $response = Http::timeout(10)
                            ->withHeaders([
                                'Authorization' => config('services.fonnte.token'),
                            ])->post('https://api.fonnte.com/send', [
                                'target' => $staff->contact,
                                'message' => $message,
                            ]);

                        if ($response->successful()) {
                            $successCount++;
                        } else {
                            $failedNumbers[] = $staff->contact;
                        }
                    } catch (\Exception $e) {
                        $failedNumbers[] = $staff->contact;
                    }
                }
            }

            // Simpan status Code STEMI ke database dengan waktu WITA
            $codeStemi = CodeStemi::create([
                'medical_record_number' => $request->medical_record_number,
                'status' => 'Running',
                'start_time' => Carbon::now('Asia/Makassar'),
                'checklist' => $request->checklist ?? [],
                'custom_message' => $request->custom_message,
            ]);

            // ✅ TRIGGER REAL-TIME UPDATE
            broadcast(new CodeStemiStatusUpdated());

            $message = 'Code STEMI berhasil diaktifkan! ';
            if ($successCount > 0) {
                $message .= "Notifikasi berhasil dikirim ke {$successCount} staf.";
            }
            if (!empty($failedNumbers)) {
                $message .= " Gagal mengirim ke " . count($failedNumbers) . " nomor.";
            }

            return redirect()->route('code-stemi.index')->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit Code STEMI dalam format JSON untuk modal.
     */
    public function edit($id)
    {
        $codeStemi = CodeStemi::findOrFail($id);
        
        return response()->json([
            'id' => $codeStemi->id,
            'medical_record_number' => $codeStemi->medical_record_number,
            'status' => $codeStemi->status,
            'checklist' => $codeStemi->checklist,
            'custom_message' => $codeStemi->custom_message,
            'start_time' => $codeStemi->start_time->setTimezone('Asia/Makassar')->toISOString(),
            'door_to_balloon_time' => $this->calculateDoorToBalloonTime($codeStemi),
        ]);
    }

    /**
     * Update data Code STEMI.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'medical_record_number' => 'required|string|max:255',
            'checklist' => 'nullable|array',
            'checklist.*' => 'string',
            'custom_message' => 'nullable|string|max:500'
        ]);

        try {
            $codeStemi = CodeStemi::findOrFail($id);
            
            $codeStemi->update([
                'medical_record_number' => $request->medical_record_number,
                'checklist' => $request->checklist ?? [],
                'custom_message' => $request->custom_message,
            ]);

            // ✅ TRIGGER REAL-TIME UPDATE
            broadcast(new CodeStemiStatusUpdated());

            return response()->json([
                'success' => true,
                'message' => 'Data Code STEMI berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus data Code STEMI.
     */
    public function destroy($id)
    {
        try {
            $codeStemi = CodeStemi::findOrFail($id);
            $codeStemi->delete();

            // ✅ TRIGGER REAL-TIME UPDATE
            broadcast(new CodeStemiStatusUpdated());

            return response()->json([
                'success' => true,
                'message' => 'Data Code STEMI berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus semua data Code STEMI.
     */
    public function deleteAll()
    {
        try {
            $count = CodeStemi::count();
            
            if ($count > 0) {
                CodeStemi::truncate();
                
                // ✅ TRIGGER REAL-TIME UPDATE
                broadcast(new CodeStemiStatusUpdated());

                return response()->json([
                    'success' => true,
                    'message' => "Semua data Code STEMI ($count data) berhasil dihapus!"
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang dapat dihapus.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus semua data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update checklist dari modal detail.
     */
    public function updateChecklist(Request $request, $id)
    {
        try {
            $codeStemi = CodeStemi::findOrFail($id);
            
            $request->validate([
                'checklist' => 'nullable|array',
                'checklist.*' => 'string'
            ]);

            $codeStemi->update([
                'checklist' => $request->checklist ?? [],
            ]);

            // ✅ TRIGGER REAL-TIME UPDATE
            broadcast(new CodeStemiStatusUpdated());

            return response()->json([
                'success' => true,
                'message' => 'Checklist berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui checklist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan detail Code STEMI dalam format JSON untuk modal.
     */
    public function show($id)
    {
        $codeStemi = CodeStemi::findOrFail($id);
        
        return response()->json([
            'id' => $codeStemi->id,
            'medical_record_number' => $codeStemi->medical_record_number,
            'status' => $codeStemi->status,
            'checklist' => $codeStemi->checklist,
            'door_to_balloon_time' => $this->calculateDoorToBalloonTime($codeStemi),
            'start_time' => $codeStemi->start_time->setTimezone('Asia/Makassar')->toISOString(),
            'end_time' => $codeStemi->end_time ? $codeStemi->end_time->setTimezone('Asia/Makassar')->toISOString() : null,
            'custom_message' => $codeStemi->custom_message,
        ]);
    }

    /**
     * Tandai Code STEMI selesai.
     */
    public function finish($id)
    {
        try {
            $code = CodeStemi::findOrFail($id);
            
            if ($code->status === 'Finished') {
                return response()->json([
                    'success' => false,
                    'message' => 'Code STEMI sudah selesai!'
                ], 400);
            }

            $code->update([
                'status' => 'Finished',
                'end_time' => Carbon::now('Asia/Makassar'),
            ]);

            // Hitung ulang duration
            $this->calculateDuration($code);

            // ✅ TRIGGER REAL-TIME UPDATE
            broadcast(new CodeStemiStatusUpdated());

            return response()->json([
                'success' => true,
                'message' => 'Code STEMI selesai!',
                'data' => [
                    'id' => $code->id,
                    'final_time' => $this->calculateDoorToBalloonTime($code)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hitung dan update duration.
     */
    private function calculateDuration($codeStemi)
    {
        if ($codeStemi->start_time && $codeStemi->end_time) {
            $start = Carbon::parse($codeStemi->start_time)->setTimezone('Asia/Makassar');
            $end = Carbon::parse($codeStemi->end_time)->setTimezone('Asia/Makassar');
            $diff = $end->diff($start);
            
            $duration = sprintf('%02dh : %02dm : %02ds', $diff->h, $diff->i, $diff->s);
            
            $codeStemi->update(['duration' => $duration]);
        }
    }

    /**
     * API untuk mendapatkan statistik terbaru (untuk real-time)
     */
    public function getStats()
    {
        try {
            $runningCount = CodeStemi::where('status', 'Running')->count();
            $finishedCount = CodeStemi::where('status', 'Finished')->count();
            
            $recentActivities = CodeStemi::orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'status' => $item->status,
                        'formatted_date' => $item->start_time->format('d M, Y'),
                        'door_to_balloon_time' => $this->calculateDoorToBalloonTime($item),
                        'user_name' => 'System'
                    ];
                });

            return response()->json([
                'success' => true,
                'runningCount' => $runningCount,
                'finishedCount' => $finishedCount,
                'recentActivities' => $recentActivities,
                'lastUpdate' => now()->setTimezone('Asia/Makassar')->format('H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik'
            ], 500);
        }
    }

    /**
     * Export data Code STEMI ke Excel.
     */
    public function export(Request $request)
    {
        $query = CodeStemi::query();

        // Terapkan filter yang sama seperti index()
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('start_time', $request->date);
        }

        if ($request->has('checklist_filter') && !empty($request->checklist_filter)) {
            $query->where(function($q) use ($request) {
                foreach ($request->checklist_filter as $checklistItem) {
                    $q->orWhereJsonContains('checklist', $checklistItem);
                }
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('medical_record_number', 'like', "%{$search}%")
                  ->orWhere('custom_message', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('duration', 'like', "%{$search}%")
                  ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(checklist, "$")) LIKE ?', ["%{$search}%"]);
            });
        }

        $data = $query->orderBy('start_time', 'desc')->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data Code STEMI yang dapat diexport.');
        }

        $fileName = 'code_stemi_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new CodeStemiExport($data), $fileName);
    }
}