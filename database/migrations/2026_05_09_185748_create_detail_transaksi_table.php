<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('transaksi_id')->constrained('transaksi', 'transaksi_id')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('m_produks', 'produk_id');
            $table->integer('jumlah');
            $table->decimal('total_harga', 15, 0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
