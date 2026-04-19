<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('role')->default(0); // 0 = customer, 1 = admin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_users');
    }
};
