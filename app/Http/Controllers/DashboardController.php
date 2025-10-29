<?php

namespace App\Http\Controllers;

use App\Models\CodeStemi;
use Illuminate\Http\Request;

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
        
        // Ambil aktivitas terbaru
        $recentActivities = CodeStemi::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'runningCount', 
            'finishedCount', 
            'recentActivities'
        ));
    }
}