<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataNakes; // pastikan model ini sudah ada

class BroadcastController extends Controller
{
    // Tampilkan halaman form dan daftar penerima
    public function index()
    {
        $nakes = DataNakes::select('nama', 'contact', 'status', 'admitted_date')->get();
        return view('broadcast.index', compact('nakes'));
    }

    // Proses kirim broadcast
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $token = env('FONNTE_TOKEN');

        // Ambil semua nomor dari kolom "contact"
        $numbers = DataNakes::pluck('contact')->toArray();

        // Gabungkan jadi string dipisahkan koma
        $numbersString = implode(',', $numbers);

        // Kirim ke API Fonnte
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $numbersString,
            'message' => $request->message,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Broadcast berhasil dikirim ke semua tenaga kesehatan!');
        } else {
            return back()->with('error', 'Gagal mengirim broadcast. Periksa token atau format nomor.');
        }
    }
}
