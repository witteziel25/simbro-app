<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rekening_pembayaran', function (Blueprint $table) {
            $table->id('rekening_id');
            $table->foreignId('informasi_id')->constrained('informasi_pembayaran', 'informasi_id')->onDelete('cascade');
            $table->string('nama_bank');
            $table->string('nomor_rekening');
            $table->string('pemilik_rekening')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekening_pembayaran');
    }
};
