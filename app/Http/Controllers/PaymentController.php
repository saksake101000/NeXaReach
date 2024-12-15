<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false; // Ganti ke true untuk produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Menangani pembuatan pembayaran dan mengarahkan pengguna ke Midtrans.
     */
    public function bayar(Request $request, Transaksi $transaksi)
    {
        // Contoh data yang diterima dari form atau API
        $data = $request->validate([
            'payment_type' => 'required|string',
            'payment_url' => 'required|string',
        ]);
    
        // Pastikan Anda menyertakan nilai untuk 'payment_type'
        $payment = new Payment([
            'transaksi_id' => $transaksi->id,
            'midtrans_order_id' => 'TRX-' . strtoupper(uniqid()), // contoh ID order
            'status' => 'pending',
            'payment_type' => $data['payment_type'], // Pastikan ini tidak kosong
            'payment_url' => $data['payment_url'],
        ]);
    
        $payment->save();
        Log::info('Pembayaran diterima');
    return response()->json(['status' => 'success']);
        // Lakukan hal lain jika perlu
    }
    


    /**
     * Menangani callback dari Midtrans untuk memperbarui status transaksi.
     */
    public function callback(Request $request)
    {
        // Ambil status pembayaran dan order_id dari callback Midtrans
        $status = $request->input('transaction_status');
        $orderId = $request->input('order_id');

        // Cari data pembayaran berdasarkan order_id
        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if ($payment) {
            // Update status pembayaran di tabel Payment
            $payment->status = $status;
            $payment->save();

            // Update status transaksi berdasarkan status pembayaran
            $transaksi = $payment->transaksi;
            if ($status == 'capture' || $status == 'settlement') {
                $transaksi->status = 'lunas';
            } else {
                $transaksi->status = 'gagal';
            }
            $transaksi->save();
        }

        // Kembalikan response sukses
        return response()->json(['status' => 'success']);
    }
}
