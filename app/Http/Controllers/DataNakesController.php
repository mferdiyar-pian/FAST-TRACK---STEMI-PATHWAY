<?php
// app/Http/Controllers/DataNakesController.php

namespace App\Http\Controllers;

use App\Models\DataNakes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataNakesController extends Controller
{
    public function index()
    {
        $data_nakes = DataNakes::orderBy('admitted_date', 'desc')->get();
        
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

            DataNakes::create([
                'nama' => $request->nama,
                'status' => $request->status,
                'contact' => $request->contact,
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
            $data_nakes->update([
                'nama' => $request->nama,
                'status' => $request->status,
                'contact' => $request->contact
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

    public function show($id)
    {
        $data_nakes = DataNakes::findOrFail($id);
        return response()->json($data_nakes);
    }
}