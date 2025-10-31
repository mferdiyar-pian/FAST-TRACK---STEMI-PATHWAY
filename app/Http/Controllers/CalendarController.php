<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    // Menampilkan halaman dashboard dengan kalender
    public function dashboard()
    {
        $runningCount = CalendarEvent::where('status', 'running')->count();
        $finishedCount = CalendarEvent::where('status', 'finished')->count();
        
        return view('dashboard.index', compact('runningCount', 'finishedCount'));
    }

    // Ambil data untuk bulan tertentu
    public function getMonthData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        
        $events = CalendarEvent::whereYear('event_date', $year)
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
            
        return response()->json($events);
    }

    // Ambil data untuk tanggal tertentu - DIPERBAIKI
    public function getDateData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        // Validasi format tanggal
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        $events = CalendarEvent::whereDate('event_date', $date)->get();
        
        // Hitung statistik untuk chart
        $runningCount = $events->where('status', 'running')->count();
        $finishedCount = $events->where('status', 'finished')->count();
            
        return response()->json([
            'date' => $date,
            'events' => $events,
            'running_count' => $runningCount,
            'finished_count' => $finishedCount,
            'total_count' => $events->count(),
            'chart_data' => [
                'running' => $runningCount,
                'finished' => $finishedCount
            ]
        ]);
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
}