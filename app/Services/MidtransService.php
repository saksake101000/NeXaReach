<?php
namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken($transactionData)
    {
        // Data transaksi untuk Midtrans
        $midtransTransaction = [
            'transaction_details' => [
                'order_id' => $transactionData['1734210943621'],
                'gross_amount' => $transactionData['gross_amount'], 
            ],
            'customer_details' => [
                'first_name' => $transactionData['first_name'],
                'last_name' => $transactionData['last_name'],
                'email' => $transactionData['email'],
                'phone' => $transactionData['phone'],
            ],
        ];

        // Menggunakan Midtrans Snap API untuk mendapatkan token
        $snapToken = Snap::getSnapToken($midtransTransaction);
        
        return $snapToken;
    }
}
