<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_StatusTransaksi extends Model
{
    use HasFactory;
    protected $table = 'status_transaksi';
    protected $primaryKey = 'status_id';
    protected $fillable = ['nama_status', 'warna'];

    public function transaksis()
    {
        return $this->hasMany(M_Transaksi::class, 'status_id', 'status_id');
    }
}
