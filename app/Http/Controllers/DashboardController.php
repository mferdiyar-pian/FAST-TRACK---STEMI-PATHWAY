<?php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan statistik
     */
    public function index()
    {
        // Hitung jumlah Code STEMI yang sedang running
        $runningCount = CodeStemi::where('status', 'Running')->count();
        
        // Hitung jumlah Code STEMI yang sudah finished
        $finishedCount = CodeStemi::where('status', 'Finished')->count();
        
        // Ambil data untuk chart (12 bulan terakhir)
        $chartData = $this->getChartData();

        return view('dashboard.index', compact(
            'runningCount', 
            'finishedCount', 
            'chartData'
        ));
    }

    /**
     * Ambil data untuk chart (12 bulan terakhir)
     */
    private function getChartData()
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        
        $monthlyData = [];
        
        // Data untuk 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {
            $targetMonth = $currentMonth - $i;
            $targetYear = $currentYear;
            
            if ($targetMonth < 1) {
                $targetMonth += 12;
                $targetYear--;
            }
            
            $runningCount = CodeStemi::whereYear('start_time', $targetYear)
                ->whereMonth('start_time', $targetMonth)
                ->where('status', 'Running')
                ->count();
                
            $finishedCount = CodeStemi::whereYear('start_time', $targetYear)
                ->whereMonth('start_time', $targetMonth)
                ->where('status', 'Finished')
                ->count();
            
            $monthlyData[] = [
                'month' => date('M', mktime(0, 0, 0, $targetMonth, 1)),
                'running' => $runningCount,
                'finished' => $finishedCount,
                'year' => $targetYear,
                'month_number' => $targetMonth
            ];
        }
        
        return $monthlyData;
    }

    /**
     * API untuk mendapatkan data berdasarkan tanggal (Code STEMI) - DIPERBAIKI
     */
    public function getDateData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        // Validasi format tanggal
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid date format'
            ], 400);
        }

        try {
            // PERBAIKAN: Hanya ambil data yang start_time-nya pada tanggal yang dipilih
            $codeStemiData = CodeStemi::whereDate('start_time', $date)
                ->orderBy('start_time', 'desc')
                ->get();

            // Hitung statistik HANYA untuk tanggal yang dipilih
            $runningCount = $codeStemiData->where('status', 'Running')->count();
            $finishedCount = $codeStemiData->where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'date' => $date,
                'running_count' => $runningCount,
                'finished_count' => $finishedCount,
                'total_count' => $codeStemiData->count(),
                'query_info' => 'Data berdasarkan start_time pada: ' . $date
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan statistik real-time (ALL TIME DATA)
     */
    public function getRealTimeStats()
    {
        try {
            $runningCount = CodeStemi::where('status', 'Running')->count();
            $finishedCount = CodeStemi::where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'runningCount' => $runningCount,
                'finishedCount' => $finishedCount,
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
     * API untuk mendapatkan statistik dashboard (ALL TIME DATA)
     */
    public function getDashboardStats()
    {
        try {
            $totalRunning = CodeStemi::where('status', 'Running')->count();
            $totalFinished = CodeStemi::where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_running' => $totalRunning,
                    'total_finished' => $totalFinished,
                ],
                'last_update' => now()->setTimezone('Asia/Makassar')->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik dashboard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan data chart (12 bulan terakhir)
     */
    public function getChartStats()
    {
        try {
            $chartData = $this->getChartData();
            
            return response()->json([
                'success' => true,
                'chart_data' => $chartData
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data chart'
            ], 500);
        }
    }
}