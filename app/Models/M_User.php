<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class M_User extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_hp',
        'alamat',
        'username',
        'password',
        'role'
    ];
    protected $hidden = [
        'password',
    ];
}
