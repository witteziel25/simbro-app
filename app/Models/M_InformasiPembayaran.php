<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_InformasiPembayaran extends Model
{
    use HasFactory;

    // --- KONFIGURASI TABEL ---

    protected $table = 'informasi_pembayaran';
    protected $primaryKey = 'informasi_id';
    protected $fillable = ['judul', 'deskripsi'];

    // --- RELASI: rekening ---

    public function rekening()
    {
        return $this->hasMany(M_RekeningPembayaran::class, 'informasi_id', 'informasi_id');
    }

    // --- RELASI: transaksis ---

    public function transaksis()
    {
        return $this->hasMany(M_Transaksi::class, 'informasi_id', 'informasi_id');
    }
}
