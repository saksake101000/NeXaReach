<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $transaksi = Transaksi::with('katalog')->findOrFail($id);

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . uniqid(),
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name,
                'email' => $transaksi->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.checkout', compact('transaksi', 'snapToken'));
    }
    public function paymentCallback(Request $request)
    {
        $json = json_decode($request->getContent(), true);

        $orderId = $json['order_id'];
        $transactionStatus = $json['transaction_status'];
        
        $transaksi = Transaksi::where('order_id', $orderId)->first();
        if ($transactionStatus === 'settlement') {
            $transaksi->status = 'sukses';
        } elseif ($transactionStatus === 'pending') {
            $transaksi->status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaksi->status = 'gagal';
        }
        $transaksi->save();

        return response()->json(['message' => 'Callback diproses']);
    }
    public function process(Request $request)
    {
        // Handle the response from Midtrans, such as updating the transaction status
        $transaksi = Transaksi::findOrFail($request->transaksi_id);
        $transaksi->status = 'lunas';  // or whatever status you want after success
        $transaksi->save();

        return redirect()->route('payment.success');
    }

    public function success()
    {
        // Show a success message or a success page
        return view('payment.success');
    }

}