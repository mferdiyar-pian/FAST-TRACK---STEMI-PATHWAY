<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // Menampilkan halaman dashboard dengan kalender
    public function dashboard()
    {
        $runningCount = CalendarEvent::where('status', 'running')->count();
        $finishedCount = CalendarEvent::where('status', 'finished')->count();
        
        // Tambahkan data dari Code STEMI
        $codeStemiRunningCount = CodeStemi::where('status', 'Running')->count();
        $codeStemiFinishedCount = CodeStemi::where('status', 'Finished')->count();
        
        // Gabungkan total
        $totalRunningCount = $runningCount + $codeStemiRunningCount;
        $totalFinishedCount = $finishedCount + $codeStemiFinishedCount;
        
        return view('dashboard.index', compact('totalRunningCount', 'totalFinishedCount'));
    }

    // Ambil data untuk bulan tertentu
    public function getMonthData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        
        // Ambil data dari CalendarEvent
        $calendarEvents = CalendarEvent::whereYear('event_date', $year)
            ->whereMonth('event_date', $month)
            ->get()
            ->groupBy(function($event) {
                return $event->event_date->format('Y-m-d');
            })
            ->map(function($dayEvents) {
                return [
                    'running' => $dayEvents->where('status', 'running')->count(),
                    'finished' => $dayEvents->where('status', 'finished')->count(),
                    'total' => $dayEvents->count(),
                    'events' => $dayEvents
                ];
            });

        // Ambil data dari CodeStemi untuk bulan yang sama
        $codeStemiEvents = CodeStemi::whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->get()
            ->groupBy(function($event) {
                return Carbon::parse($event->start_time)->format('Y-m-d');
            })
            ->map(function($dayEvents) {
                return [
                    'running' => $dayEvents->where('status', 'Running')->count(),
                    'finished' => $dayEvents->where('status', 'Finished')->count(),
                    'total' => $dayEvents->count(),
                    'events' => $dayEvents
                ];
            });

        // Gabungkan data dari kedua sumber
        $combinedEvents = [];
        
        // Gabungkan semua tanggal yang ada
        $allDates = array_unique(array_merge(
            array_keys($calendarEvents->toArray()),
            array_keys($codeStemiEvents->toArray())
        ));
        
        sort($allDates);

        foreach ($allDates as $date) {
            $calendarData = $calendarEvents[$date] ?? [
                'running' => 0,
                'finished' => 0,
                'total' => 0,
                'events' => collect()
            ];
            
            $codeStemiData = $codeStemiEvents[$date] ?? [
                'running' => 0,
                'finished' => 0,
                'total' => 0,
                'events' => collect()
            ];

            $combinedEvents[$date] = [
                'running' => $calendarData['running'] + $codeStemiData['running'],
                'finished' => $calendarData['finished'] + $codeStemiData['finished'],
                'total' => $calendarData['total'] + $codeStemiData['total'],
                'events' => $calendarData['events']->merge($codeStemiData['events']),
                'calendar_events' => $calendarData['events'],
                'code_stemi_events' => $codeStemiData['events']
            ];
        }
            
        return response()->json($combinedEvents);
    }

    // Ambil data untuk tanggal tertentu - TERINTEGRASI dengan Code STEMI
    public function getDateData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        // Validasi format tanggal
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        try {
            // Ambil data dari CalendarEvent
            $calendarEvents = CalendarEvent::whereDate('event_date', $date)->get();
            
            // Ambil data dari CodeStemi untuk tanggal yang sama
            $codeStemiData = CodeStemi::whereDate('start_time', $date)
                ->orWhereDate('end_time', $date)
                ->orWhereDate('created_at', $date)
                ->orderBy('start_time', 'desc')
                ->get();

            // Gabungkan semua events
            $allEvents = $calendarEvents->merge($codeStemiData);

            // Hitung statistik untuk chart
            $runningCount = $calendarEvents->where('status', 'running')->count() 
                          + $codeStemiData->where('status', 'Running')->count();
                          
            $finishedCount = $calendarEvents->where('status', 'finished')->count() 
                           + $codeStemiData->where('status', 'Finished')->count();

            // Format data Code STEMI untuk response
            $formattedCodeStemiData = $codeStemiData->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Code STEMI - ' . $item->status,
                    'description' => $item->custom_message,
                    'status' => strtolower($item->status),
                    'patient_name' => null,
                    'doctor_name' => null,
                    'event_date' => $item->start_time,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'door_to_balloon_time' => $item->door_to_balloon_time,
                    'duration' => $item->duration,
                    'checklist' => $item->checklist,
                    'is_code_stemi' => true, // Flag untuk membedakan jenis event
                    'formatted_time' => $item->start_time ? Carbon::parse($item->start_time)->format('H:i') : 'N/A'
                ];
            });

            // Format data CalendarEvent untuk response
            $formattedCalendarEvents = $calendarEvents->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'status' => $item->status,
                    'patient_name' => $item->patient_name,
                    'doctor_name' => $item->doctor_name,
                    'event_date' => $item->event_date,
                    'start_time' => $item->event_date,
                    'end_time' => null,
                    'door_to_balloon_time' => null,
                    'duration' => null,
                    'checklist' => null,
                    'is_code_stemi' => false,
                    'formatted_time' => $item->event_date ? $item->event_date->format('H:i') : 'N/A'
                ];
            });

            // Gabungkan semua events yang sudah diformat
            $allFormattedEvents = $formattedCalendarEvents->merge($formattedCodeStemiData)
                ->sortBy('start_time');
                
            return response()->json([
                'date' => $date,
                'events' => $allFormattedEvents,
                'calendar_events' => $formattedCalendarEvents,
                'code_stemi_data' => $formattedCodeStemiData,
                'running_count' => $runningCount,
                'finished_count' => $finishedCount,
                'total_count' => $allEvents->count(),
                'chart_data' => [
                    'running' => $runningCount,
                    'finished' => $finishedCount
                ],
                'statistics' => [
                    'calendar_running' => $calendarEvents->where('status', 'running')->count(),
                    'calendar_finished' => $calendarEvents->where('status', 'finished')->count(),
                    'code_stemi_running' => $codeStemiData->where('status', 'Running')->count(),
                    'code_stemi_finished' => $codeStemiData->where('status', 'Finished')->count(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch date data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Ambil data khusus Code STEMI untuk tanggal tertentu
    public function getCodeStemiByDate(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        // Validasi format tanggal
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        try {
            // Ambil data Code STEMI untuk tanggal tertentu
            $codeStemiData = CodeStemi::whereDate('start_time', $date)
                ->orWhereDate('end_time', $date)
                ->orWhereDate('created_at', $date)
                ->orderBy('start_time', 'desc')
                ->get();

            // Hitung statistik
            $runningCount = $codeStemiData->where('status', 'Running')->count();
            $finishedCount = $codeStemiData->where('status', 'Finished')->count();

            // Format data untuk response
            $formattedData = $codeStemiData->map(function($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'duration' => $item->duration,
                    'door_to_balloon_time' => $item->door_to_balloon_time,
                    'custom_message' => $item->custom_message,
                    'checklist' => $item->checklist,
                    'formatted_start_time' => $item->start_time ? Carbon::parse($item->start_time)->format('H:i:s') : 'N/A',
                    'formatted_date' => $item->start_time ? Carbon::parse($item->start_time)->format('d M Y') : 'N/A',
                    'is_active' => $item->status === 'Running'
                ];
            });

            return response()->json([
                'success' => true,
                'date' => $date,
                'code_stemi_data' => $formattedData,
                'running_count' => $runningCount,
                'finished_count' => $finishedCount,
                'total_count' => $codeStemiData->count(),
                'chart_data' => [
                    'running' => $runningCount,
                    'finished' => $finishedCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Code STEMI: ' . $e->getMessage()
            ], 500);
        }
    }

    // Simpan event baru
    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'event_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:running,finished',
            'patient_name' => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255'
        ]);

        $event = CalendarEvent::create($validated);
        
        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Event berhasil disimpan!'
        ]);
    }

    // Form untuk menambah event baru
    public function create()
    {
        return view('calendar.create');
    }

    // Hapus event
    public function destroy($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus!'
        ]);
    }

    // Update event
    public function updateEvent(Request $request, $id)
    {
        $validated = $request->validate([
            'event_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:running,finished',
            'patient_name' => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255'
        ]);

        $event = CalendarEvent::findOrFail($id);
        $event->update($validated);

        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Event berhasil diperbarui!'
        ]);
    }

    // Get event by ID
    public function getEvent($id)
    {
        $event = CalendarEvent::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    // Get statistics for dashboard
    public function getDashboardStats()
    {
        try {
            // Data dari CalendarEvent
            $calendarRunning = CalendarEvent::where('status', 'running')->count();
            $calendarFinished = CalendarEvent::where('status', 'finished')->count();
            
            // Data dari CodeStemi
            $codeStemiRunning = CodeStemi::where('status', 'Running')->count();
            $codeStemiFinished = CodeStemi::where('status', 'Finished')->count();
            
            // Total gabungan
            $totalRunning = $calendarRunning + $codeStemiRunning;
            $totalFinished = $calendarFinished + $codeStemiFinished;
            
            // Recent activities (gabungan)
            $recentCalendarEvents = CalendarEvent::orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function($event) {
                    return [
                        'id' => $event->id,
                        'type' => 'calendar',
                        'title' => $event->title,
                        'status' => $event->status,
                        'time' => $event->event_date->format('H:i'),
                        'date' => $event->event_date->format('d M Y'),
                        'description' => $event->description
                    ];
                });
                
            $recentCodeStemi = CodeStemi::orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function($event) {
                    return [
                        'id' => $event->id,
                        'type' => 'code_stemi',
                        'title' => 'Code STEMI - ' . $event->status,
                        'status' => $event->status,
                        'time' => $event->start_time ? Carbon::parse($event->start_time)->format('H:i') : 'N/A',
                        'date' => $event->start_time ? Carbon::parse($event->start_time)->format('d M Y') : 'N/A',
                        'description' => $event->custom_message
                    ];
                });
            
            // Gabungkan dan urutkan berdasarkan waktu
            $recentActivities = $recentCalendarEvents->merge($recentCodeStemi)
                ->sortByDesc(function($item) {
                    return $item['date'] . ' ' . $item['time'];
                })
                ->values()
                ->take(5);

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_running' => $totalRunning,
                    'total_finished' => $totalFinished,
                    'calendar_running' => $calendarRunning,
                    'calendar_finished' => $calendarFinished,
                    'code_stemi_running' => $codeStemiRunning,
                    'code_stemi_finished' => $codeStemiFinished,
                ],
                'recent_activities' => $recentActivities,
                'last_update' => now()->setTimezone('Asia/Makassar')->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik dashboard: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get monthly statistics for chart
    public function getMonthlyStats(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        try {
            $monthlyStats = [];
            
            for ($month = 1; $month <= 12; $month++) {
                // Data CalendarEvent
                $calendarRunning = CalendarEvent::whereYear('event_date', $year)
                    ->whereMonth('event_date', $month)
                    ->where('status', 'running')
                    ->count();
                    
                $calendarFinished = CalendarEvent::whereYear('event_date', $year)
                    ->whereMonth('event_date', $month)
                    ->where('status', 'finished')
                    ->count();
                
                // Data CodeStemi
                $codeStemiRunning = CodeStemi::whereYear('start_time', $year)
                    ->whereMonth('start_time', $month)
                    ->where('status', 'Running')
                    ->count();
                    
                $codeStemiFinished = CodeStemi::whereYear('start_time', $year)
                    ->whereMonth('start_time', $month)
                    ->where('status', 'Finished')
                    ->count();
                
                $monthlyStats[] = [
                    'month' => date('M', mktime(0, 0, 0, $month, 1)),
                    'running' => $calendarRunning + $codeStemiRunning,
                    'finished' => $calendarFinished + $codeStemiFinished,
                    'calendar_running' => $calendarRunning,
                    'calendar_finished' => $calendarFinished,
                    'code_stemi_running' => $codeStemiRunning,
                    'code_stemi_finished' => $codeStemiFinished
                ];
            }
            
            return response()->json([
                'success' => true,
                'year' => $year,
                'monthly_stats' => $monthlyStats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik bulanan: ' . $e->getMessage()
            ], 500);
        }
    }
}