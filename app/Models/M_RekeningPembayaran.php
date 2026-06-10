<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_RekeningPembayaran extends Model
{
    use HasFactory;
    // --- KONFIGURASI TABEL ---
    protected $table = 'rekening_pembayaran';
    protected $primaryKey = 'rekening_id';
    protected $fillable = ['informasi_id', 'nama_bank', 'nomor_rekening', 'pemilik_rekening'];

    // --- RELASI: informasiPembayaran ---

    public function informasiPembayaran()
    {
        return $this->belongsTo(M_InformasiPembayaran::class, 'informasi_id', 'informasi_id');
    }
}
