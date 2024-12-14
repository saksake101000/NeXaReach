<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'user_id',
        'status',
        'payment_method',
        'payment_url',
        'payment_code',
        'payment_status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}