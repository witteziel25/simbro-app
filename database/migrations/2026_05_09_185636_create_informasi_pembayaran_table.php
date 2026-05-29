<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('informasi_pembayaran', function (Blueprint $table) {
            $table->id('informasi_id');
            $table->text('informasi_pembayaran');
            $table->string('metode_pembayaran');
            $table->string('no_hp', 15);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informasi_pembayaran');
    }
};
