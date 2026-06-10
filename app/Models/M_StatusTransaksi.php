<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_StatusTransaksi extends Model
{
    use HasFactory;
    // --- KONFIGURASI TABEL ---
    protected $table = 'status_transaksi';
    protected $primaryKey = 'status_id';
    protected $fillable = ['nama_status', 'warna'];

    // --- RELASI: transaksis ---

    public function transaksis()
    {
        return $this->hasMany(M_Transaksi::class, 'status_id', 'status_id');
    }
}
