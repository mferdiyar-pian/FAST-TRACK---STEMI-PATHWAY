<?php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataNakes;
use Carbon\Carbon;

class CodeStemiController extends Controller
{
    /**
     * Tampilkan halaman utama Code STEMI.
     */
    public function index()
    {
        $data = CodeStemi::latest()->get();
        return view('code-stemi.index', compact('data'));
    }

    /**
     * Aktivasi Code STEMI — kirim broadcast WA & catat waktu mulai.
     */
    public function store(Request $request)
    {
        $request->validate([
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
                'status' => 'Running',
                'start_time' => Carbon::now('Asia/Makassar'),
                'checklist' => $request->checklist ?? [],
                'custom_message' => $request->custom_message,
            ]);

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
            'status' => $codeStemi->status,
            'checklist' => $codeStemi->checklist,
            'door_to_balloon_time' => $codeStemi->door_to_balloon_time,
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
                return redirect()->route('code-stemi.index')->with('error', 'Code STEMI sudah selesai!');
            }

            $code->update([
                'status' => 'Finished',
                'end_time' => Carbon::now('Asia/Makassar'),
            ]);

            // Hitung ulang duration
            $this->calculateDuration($code);

            return redirect()->route('code-stemi.index')->with('success', 'Code STEMI selesai!');

        } catch (\Exception $e) {
            return redirect()->route('code-stemi.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data Code STEMI.
     */
    public function destroy($id)
    {
        try {
            $code = CodeStemi::findOrFail($id);
            $code->delete();

            return redirect()->route('code-stemi.index')->with('success', 'Data berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('code-stemi.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
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
}