<?php
// app/Http/Controllers/DataNakesController.php

namespace App\Http\Controllers;

use App\Models\DataNakes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\DataNakesExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('admitted_date', $request->date);
        }
        
        // Filter berdasarkan pencarian yang lebih komprehensif
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%")
                  ->orWhereDate('admitted_date', 'like', "%{$search}%")
                  ->orWhere('admitted_date', 'like', "%{$search}%");
            });
        }
        
        // Pagination dengan 10 data per halaman
        $data_nakes = $query->orderBy('admitted_date', 'desc')->paginate(10);
        
        // Tambahkan parameter pencarian ke pagination links
        $data_nakes->appends($request->all());
        
        return view('data-nakes.index', compact('data_nakes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|in:Dokter,Perawat,Laboran',
            'contact' => 'required|string|max:15'
        ]);

        try {
            DB::beginTransaction();

            // Format contact number untuk konsistensi
            $contact = preg_replace('/[^0-9]/', '', $request->contact);
            
            DataNakes::create([
                'nama' => $request->nama,
                'status' => $request->status,
                'contact' => $contact,
                'admitted_date' => now()
            ]);

            DB::commit();

            return redirect()->route('data-nakes.index')
                ->with('success', 'Data nakes berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|in:Dokter,Perawat,Laboran',
            'contact' => 'required|string|max:15'
        ]);

        try {
            DB::beginTransaction();

            $data_nakes = DataNakes::findOrFail($id);
            
            // Format contact number untuk konsistensi
            $contact = preg_replace('/[^0-9]/', '', $request->contact);
            
            $data_nakes->update([
                'nama' => $request->nama,
                'status' => $request->status,
                'contact' => $contact
            ]);

            DB::commit();

            return redirect()->route('data-nakes.index')
                ->with('success', 'Data nakes berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data_nakes = DataNakes::findOrFail($id);
            $data_nakes->delete();

            DB::commit();

            return redirect()->route('data-nakes.index')
                ->with('success', 'Data nakes berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk hapus semua data
    public function deleteAll()
    {
        try {
            DB::beginTransaction();

            $count = DataNakes::count();
            
            if ($count > 0) {
                DataNakes::truncate(); // Menghapus semua data
                
                DB::commit();
                return redirect()->route('data-nakes.index')
                    ->with('success', "Semua data nakes ($count data) berhasil dihapus.");
            } else {
                return redirect()->route('data-nakes.index')
                    ->with('info', 'Tidak ada data yang dapat dihapus.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data_nakes = DataNakes::findOrFail($id);
        return response()->json($data_nakes);
    }

    public function edit($id)
    {
        $data_nakes = DataNakes::findOrFail($id);
        return response()->json($data_nakes);
    }

    public function export()
    {
        return Excel::download(new DataNakesExport, 'data_nakes.xlsx');
    }
}