<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'total_harga'];

    public function transaksi()
    {
        return $this->belongsTo(M_Transaksi::class, 'transaksi_id', 'transaksi_id');
    }

    public function produk()
    {
        return $this->belongsTo(M_Produk::class, 'produk_id', 'produk_id')->withTrashed();
    }
}
