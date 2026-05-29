<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'user_id', 'informasi_id', 'rekening_id', 'status_id', 'no_resi',
        'tanggal_pemesanan', 'metode_pembayaran', 'bukti_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(M_User::class, 'user_id', 'user_id');
    }

    public function informasiPembayaran()
    {
        return $this->belongsTo(M_InformasiPembayaran::class, 'informasi_id', 'informasi_id');
    }

    public function status()
    {
        return $this->belongsTo(M_StatusTransaksi::class, 'status_id', 'status_id');
    }

    public function details()
    {
        return $this->hasMany(M_DetailTransaksi::class, 'transaksi_id', 'transaksi_id');
    }

    public function rekening()
    {
        return $this->belongsTo(M_RekeningPembayaran::class, 'rekening_id', 'rekening_id');
    }

    public function ulasan()
    {
        return $this->hasOne(M_Ulasan::class, 'transaksi_id', 'transaksi_id');
    }
}
