<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->id('gallery_id');
            $table->string('gambar'); // path gambar
            $table->string('judul');
            $table->string('subjudul');
            $table->text('artikel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery');
    }
};
