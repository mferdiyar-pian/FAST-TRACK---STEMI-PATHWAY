<?php
// app/Http/Controllers/DataNakesController.php

namespace App\Http\Controllers;

use App\Models\DataNakes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataNakesController extends Controller
{
    public function index(Request $request)
    {
        $query = DataNakes::query();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('admitted_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('admitted_date', '<=', $request->end_date);
        }
        
        // Filter berdasarkan pencarian nama
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortField = $request->get('sort_field', 'admitted_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        $allowedSortFields = ['admitted_date', 'nama', 'status', 'contact'];
        $allowedSortDirections = ['asc', 'desc'];
        
        if (in_array($sortField, $allowedSortFields) && in_array($sortDirection, $allowedSortDirections)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('admitted_date', 'desc');
        }

        $data_nakes = $query->get();
        
        // Jika request AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'data_nakes' => $data_nakes,
                'html' => view('data-nakes.partials.table', compact('data_nakes'))->render()
            ]);
        }
        
        return view('data-nakes.index', compact('data_nakes'));
    }

    // ... method lainnya (store, update, destroy, show) tetap sama
}