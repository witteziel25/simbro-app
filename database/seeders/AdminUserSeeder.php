<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        if (!M_User::where('username', 'admin')->exists()) {
            M_User::create([
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@simbro.com',
                'no_hp' => '081234567890',
                'alamat' => 'Kantor Pusat SIMBRO',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 1, 
            ]);
        }
    }
}
