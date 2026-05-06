<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_produks', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 0);
            $table->integer('stok');
            $table->string('kategori');
            $table->string('foto')->nullable(); // path foto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_produks');
    }
};
