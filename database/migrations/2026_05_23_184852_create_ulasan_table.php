<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('ulasan_id');
            $table->foreignId('user_id')->constrained('m_users', 'user_id')->onDelete('cascade');
            $table->foreignId('transaksi_id')->constrained('transaksi', 'transaksi_id')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->min(1)->max(5);
            $table->text('ulasan');
            $table->timestamps();

            $table->unique('transaksi_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasan');
    }
};
