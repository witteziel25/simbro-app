<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->datetime('tanggal_pemesanan')->change();
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->date('tanggal_pemesanan')->change();
        });
    }
};
