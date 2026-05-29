<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('status_id');
        });

        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->string('metode_pembayaran')->after('informasi_pembayaran');
        });

        // Hapus kolom metode_pembayaran dari transaksi
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};
