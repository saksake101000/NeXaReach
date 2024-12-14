<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Simpan transaksi baru dan buat Snap Token.
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

        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_3DS', true);

        // Data untuk transaksi di Midtrans
        $transactionData = [
            'transaction_details' => [
                'order_id' => $transaksi->id,  // Gunakan ID transaksi sebagai order_id
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->user()->name,  // Nama pengguna
                'email' => $request->user()->email,     // Email pengguna
                'phone' => $request->user()->phone,     // Nomor telepon pengguna
            ],
        ];

        // Buat Snap Token untuk pembayaran
        try {
            $snapToken = Snap::getSnapToken($transactionData);
        } catch (\Exception $e) {
            return redirect()->route('transaksi.index')->with('error', 'Gagal membuat Snap Token: ' . $e->getMessage());
        }

        // Simpan Snap Token ke dalam transaksi
        $transaksi->update([
            'snap_token' => $snapToken
        ]);

        // Redirect ke halaman checkout
        return view('transaksi.checkout', compact('transaksi'));
    }
    
    /**
     * Tampilkan daftar transaksi.
     */
    public function index()
    {
        // Ambil semua transaksi untuk user yang sedang login
        $transaksis = Transaksi::with(['katalog', 'user'])
                            ->where('user_id', auth()->id()) // Filter berdasarkan user_id yang sedang login
                            ->get();
    
        // Kirim data transaksi ke view 'transaksi.index'
        return view('transaksi', compact('transaksis'));
    }
    

    /**
     * Halaman checkout untuk memproses pembayaran
     */
    public function checkout($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Cek apakah transaksi sudah dibayar atau belum
        if ($transaksi->status === 'sukses') {
            return redirect()->route('transaksi.index')->with('status', 'Pembayaran sudah dilakukan.');
        }

        if (!$transaksi->snap_token) {
            return redirect()->route('transaksi.index')->with('error', 'Snap Token tidak ditemukan.');
        }

        // Kirim Snap Token ke halaman checkout
        return view('transaksi.checkout', compact('transaksi'));
    }

    public function handleMidtransCallback(Request $request)
    {
        // Dapatkan status transaksi dan order_id dari Midtrans
        $status = $request->input('transaction_status');
        $orderId = $request->input('order_id');

        // Log data yang diterima untuk debugging
        Log::info('Midtrans Callback:', $request->all());
        
        // Cek apakah transaksi ditemukan
        $transaksi = Transaksi::find($orderId);
        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan dengan Order ID ' . $orderId);
        }

        
        // Update status transaksi berdasarkan status yang diterima
        switch ($status) {
            case 'success':
                $transaksi->update(['status' => 'sukses']);
                break;
            case 'pending':
                $transaksi->update(['status' => 'belum bayar']);
                break;
            case 'cancel':
                $transaksi->update(['status' => 'gagal']);
                break;
            default:
                Log::error('Status transaksi tidak dikenali: ' . $status);
                break;
        }

        return redirect()->route('transaksi.index')->with('status', 'Pembayaran berhasil diproses.');
    }
}