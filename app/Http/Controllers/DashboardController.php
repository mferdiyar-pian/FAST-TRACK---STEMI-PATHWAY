<?php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    private function getChartData($range = 'monthly')
    {
        if ($range === 'yearly') {
            return $this->getYearlyChartData();
        }
        
        // Default: monthly data (12 bulan terakhir)
        return $this->getMonthlyChartData();
    }

    /**
     * Data bulanan - 12 bulan terakhir
     */
    private function getMonthlyChartData()
    {
        $monthlyData = [];
        $currentDate = Carbon::now();
        
        for ($i = 11; $i >= 0; $i--) {
            $targetDate = $currentDate->copy()->subMonths($i);
            $year = $targetDate->year;
            $month = $targetDate->month;
            
            $runningCount = CodeStemi::whereYear('start_time', $year)
                ->whereMonth('start_time', $month)
                ->where('status', 'Running')
                ->count();
                
            $finishedCount = CodeStemi::whereYear('start_time', $year)
                ->whereMonth('start_time', $month)
                ->where('status', 'Finished')
                ->count();
            
            $monthlyData[] = [
                'month' => $targetDate->format('M'),
                'running' => $runningCount,
                'finished' => $finishedCount,
                'year' => $year,
                'month_number' => $month
            ];
        }
        
        return $monthlyData;
    }

    /**
     * Data tahunan - 5 tahun terakhir
     */
    private function getYearlyChartData()
    {
        $yearlyData = [];
        $currentYear = Carbon::now()->year;
        
        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            
            $runningCount = CodeStemi::whereYear('start_time', $year)
                ->where('status', 'Running')
                ->count();
                
            $finishedCount = CodeStemi::whereYear('start_time', $year)
                ->where('status', 'Finished')
                ->count();
            
            $yearlyData[] = [
                'month' => $year, // Use year as label
                'running' => $runningCount,
                'finished' => $finishedCount,
                'year' => $year,
                'month_number' => null
            ];
        }
        
        return $yearlyData;
    }

    /**
     * API untuk mendapatkan data berdasarkan tanggal (Code STEMI)
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
            // Ambil data yang start_time-nya pada tanggal yang dipilih
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
     * API untuk mendapatkan data chart (diperbaiki untuk support monthly/yearly)
     */
    public function getChartStats(Request $request)
    {
        try {
            $range = $request->input('range', 'monthly');
            $chartData = $this->getChartData($range);
            
            // Format response berdasarkan range
            $labels = [];
            $runningData = [];
            $finishedData = [];
            
            foreach ($chartData as $data) {
                $labels[] = $data['month'];
                $runningData[] = $data['running'];
                $finishedData[] = $data['finished'];
            }
            
            return response()->json([
                'success' => true,
                'chart_data' => $chartData,
                'labels' => $labels,
                'running' => $runningData,
                'finished' => $finishedData,
                'range' => $range
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data chart: ' . $e->getMessage()
            ], 500);
        }
    }
}