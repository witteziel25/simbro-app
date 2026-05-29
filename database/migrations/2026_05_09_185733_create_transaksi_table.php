<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->foreignId('user_id')->constrained('m_users', 'user_id');
            $table->foreignId('informasi_id')->nullable()->constrained('informasi_pembayaran', 'informasi_id')->onDelete('set null');
            $table->foreignId('status_id')->constrained('status_transaksi', 'status_id');
            $table->string('no_resi')->nullable();
            $table->date('tanggal_pemesanan');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
