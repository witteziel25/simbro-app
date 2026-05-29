<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_StatusTransaksi;

class StatusTransaksiSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['nama_status' => 'diproses', 'warna' => 'orange'],
            ['nama_status' => 'dibayar', 'warna' => 'green'],
            ['nama_status' => 'dibatalkan', 'warna' => 'red'],
            ['nama_status' => 'dikirim', 'warna' => 'blue'],
            ['nama_status' => 'diterima', 'warna' => 'teal'],
        ];
        foreach ($statuses as $status) {
            M_StatusTransaksi::create($status);
        }
    }
}
