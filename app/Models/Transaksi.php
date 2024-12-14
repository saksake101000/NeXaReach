<?php

// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Katalog;
use App\Models\Payment;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'katalog_id',
        'user_id',
        'total_harga',
        'additional',
        'status',
        'snap_token',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'katalog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}