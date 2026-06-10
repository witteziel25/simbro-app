<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Gallery extends Model
{
    use HasFactory;

    // --- KONFIGURASI TABEL ---

    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    protected $fillable = ['gambar', 'judul', 'keterangan', 'artikel']; 
}
