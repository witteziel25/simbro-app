<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    protected $primaryKey = 'ulasan_id';
    protected $fillable = ['user_id', 'transaksi_id', 'rating', 'ulasan'];

    public function user()
    {
        return $this->belongsTo(M_User::class, 'user_id', 'user_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(M_Transaksi::class, 'transaksi_id', 'transaksi_id');
    }
}
