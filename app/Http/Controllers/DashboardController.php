<?php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan statistik REAL dari Code STEMI
     */
    public function index()
    {
        try {
            // Hitung jumlah Code STEMI yang sedang running - DATA ASLI
            $runningCount = CodeStemi::where('status', 'Running')->count();
            
            // Hitung jumlah Code STEMI yang sudah finished - DATA ASLI
            $finishedCount = CodeStemi::where('status', 'Finished')->count();
            
            // Ambil data untuk chart (12 bulan terakhir) - DATA ASLI
            $chartData = $this->getMonthlyChartData();

            return view('dashboard.index', compact(
                'runningCount', 
                'finishedCount', 
                'chartData'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            $runningCount = 0;
            $finishedCount = 0;
            $chartData = $this->generateSampleChartData();

            return view('dashboard.index', compact(
                'runningCount', 
                'finishedCount', 
                'chartData'
            ));
        }
    }

    /**
     * Data bulanan - 12 bulan terakhir - DATA ASLI dari Code STEMI
     */
    private function getMonthlyChartData()
    {
        try {
            $monthlyData = [];
            $currentDate = Carbon::now();
            
            for ($i = 11; $i >= 0; $i--) {
                $targetDate = $currentDate->copy()->subMonths($i);
                $year = $targetDate->year;
                $month = $targetDate->month;
                
                // Hitung running dan finished untuk bulan tersebut - DATA ASLI
                $runningCount = CodeStemi::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('status', 'Running')
                    ->count();
                    
                $finishedCount = CodeStemi::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
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

        } catch (\Exception $e) {
            // Fallback ke sample data jika error
            return $this->generateSampleChartData();
        }
    }

    /**
     * Data tahunan - 5 tahun terakhir - DATA ASLI dari Code STEMI
     */
    private function getYearlyChartData()
    {
        try {
            $yearlyData = [];
            $currentYear = Carbon::now()->year;
            
            for ($i = 4; $i >= 0; $i--) {
                $year = $currentYear - $i;
                
                // Hitung running dan finished untuk tahun tersebut - DATA ASLI
                $runningCount = CodeStemi::whereYear('created_at', $year)
                    ->where('status', 'Running')
                    ->count();
                    
                $finishedCount = CodeStemi::whereYear('created_at', $year)
                    ->where('status', 'Finished')
                    ->count();
                
                $yearlyData[] = [
                    'month' => (string)$year,
                    'running' => $runningCount,
                    'finished' => $finishedCount,
                    'year' => $year
                ];
            }
            
            return $yearlyData;

        } catch (\Exception $e) {
            return $this->generateYearlySampleData();
        }
    }

    /**
     * Generate sample data untuk monthly chart (fallback)
     */
    private function generateSampleChartData()
    {
        $monthlyData = [];
        $currentDate = Carbon::now();
        
        for ($i = 11; $i >= 0; $i--) {
            $targetDate = $currentDate->copy()->subMonths($i);
            
            $monthlyData[] = [
                'month' => $targetDate->format('M'),
                'running' => 0,
                'finished' => 0,
                'year' => $targetDate->year,
                'month_number' => $targetDate->month
            ];
        }
        
        return $monthlyData;
    }

    /**
     * Generate sample data untuk yearly chart (fallback)
     */
    private function generateYearlySampleData()
    {
        $yearlyData = [];
        $currentYear = Carbon::now()->year;
        
        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            
            $yearlyData[] = [
                'month' => (string)$year,
                'running' => 0,
                'finished' => 0,
                'year' => $year
            ];
        }
        
        return $yearlyData;
    }

    /**
     * API untuk mendapatkan data berdasarkan tanggal - DATA ASLI
     */
    public function getDateData(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        try {
            // Ambil data berdasarkan tanggal - DATA ASLI
            $codeStemiData = CodeStemi::whereDate('created_at', $date)->get();

            $runningCount = $codeStemiData->where('status', 'Running')->count();
            $finishedCount = $codeStemiData->where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'date' => $date,
                'running_count' => $runningCount,
                'finished_count' => $finishedCount,
                'total_count' => $codeStemiData->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data'
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan data chart berdasarkan range - DATA ASLI
     */
    public function getChartStats(Request $request)
    {
        try {
            $range = $request->input('range', 'monthly');
            
            // Ambil data berdasarkan range - DATA ASLI
            if ($range === 'yearly') {
                $chartData = $this->getYearlyChartData();
            } else {
                $chartData = $this->getMonthlyChartData();
            }
            
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
            // Fallback ke sample data jika error
            $fallbackData = $range === 'yearly' ? $this->generateYearlySampleData() : $this->generateSampleChartData();
            $labels = array_column($fallbackData, 'month');
            $runningData = array_column($fallbackData, 'running');
            $finishedData = array_column($fallbackData, 'finished');
            
            return response()->json([
                'success' => true,
                'chart_data' => $fallbackData,
                'labels' => $labels,
                'running' => $runningData,
                'finished' => $finishedData,
                'range' => $range
            ]);
        }
    }

    /**
     * API untuk mendapatkan statistik real-time
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
     * API untuk mendapatkan statistik dashboard
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
                'message' => 'Gagal mengambil statistik dashboard'
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan statistik bulanan
     */
    public function getMonthlyStats(Request $request)
    {
        try {
            $year = $request->input('year', date('Y'));
            $monthlyStats = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $runningCount = CodeStemi::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('status', 'Running')
                    ->count();
                    
                $finishedCount = CodeStemi::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('status', 'Finished')
                    ->count();
                
                $monthlyStats[] = [
                    'month' => date('M', mktime(0, 0, 0, $month, 1)),
                    'running' => $runningCount,
                    'finished' => $finishedCount,
                    'year' => $year,
                    'month_number' => $month
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
                'message' => 'Gagal mengambil statistik bulanan'
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan data Code STEMI berdasarkan tanggal
     */
    public function getCodeStemiByDate(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        try {
            $codeStemiData = CodeStemi::whereDate('created_at', $date)
                ->orderBy('created_at', 'desc')
                ->get();

            $runningCount = $codeStemiData->where('status', 'Running')->count();
            $finishedCount = $codeStemiData->where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'date' => $date,
                'code_stemi_data' => $codeStemiData,
                'running_count' => $runningCount,
                'finished_count' => $finishedCount,
                'total_count' => $codeStemiData->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Code STEMI'
            ], 500);
        }
    }

    /**
     * API untuk live stats
     */
    public function getLiveStats()
    {
        try {
            $runningCount = CodeStemi::where('status', 'Running')->count();
            $finishedCount = CodeStemi::where('status', 'Finished')->count();

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_running' => $runningCount,
                    'total_finished' => $finishedCount,
                ],
                'last_update' => now()->setTimezone('Asia/Makassar')->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data live'
            ], 500);
        }
    }

    /**
     * Debug endpoint
     */
    public function debugDate($date)
    {
        try {
            $codeStemiData = CodeStemi::whereDate('created_at', $date)->get();

            return response()->json([
                'date' => $date,
                'total_records' => $codeStemiData->count(),
                'running_count' => $codeStemiData->where('status', 'Running')->count(),
                'finished_count' => $codeStemiData->where('status', 'Finished')->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}