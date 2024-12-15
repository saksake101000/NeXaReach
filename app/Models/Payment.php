<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    // Specify which columns are mass assignable
    protected $fillable = [
        'transaksi_id',
        'midtrans_order_id',
        'status',
        'payment_type',
        'payment_url',
    ];

    // Relationship with the Transaksi model
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Optional: Disable timestamps if not needed
    // public $timestamps = false;

    // Optional: Define a scope for querying payments with 'pending' status
    // public function scopePending($query)
    // {
    //     return $query->where('status', 'pending');
    // }
}
