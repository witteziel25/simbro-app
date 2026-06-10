<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_Produk extends Model
{
    use HasFactory, SoftDeletes;

    // --- KONFIGURASI TABEL ---

    protected $table = 'm_produks';
    protected $primaryKey = 'produk_id';
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'foto',
    ];
}
