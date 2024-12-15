<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Katalog;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'katalog_id' => 'required|exists:katalog,id', // Pastikan katalog_id valid
            'user_id' => 'required|exists:users,id',     // Pastikan user_id valid
            'additional' => 'nullable|string|max:255',  // Catatan tambahan opsional
        ]);

        // Ambil data katalog untuk menghitung harga
        $katalog = Katalog::findOrFail($validated['katalog_id']);

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'katalog_id' => $validated['katalog_id'],
            'user_id' => $validated['user_id'],
            'total_harga' => $katalog->harga,
            'additional' => $validated['additional'],
            'status' => 'belum bayar', // Default status transaksi
        ]);

        // Redirect ke halaman transaksi dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
    }

    /**
     * Tampilkan daftar transaksi.
     */
    public function index()
    {
        // Ambil semua transaksi, dengan relasi ke katalog dan user
        $transaksis = Transaksi::with(['katalog', 'user'])->get();

        // Kirim data transaksi ke view 'transaksi'
        return view('transaksi', compact('transaksis'));
    }

}