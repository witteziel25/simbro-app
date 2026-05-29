<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreignId('rekening_id')->nullable()->after('informasi_id')->constrained('rekening_pembayaran', 'rekening_id')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['rekening_id']);
            $table->dropColumn('rekening_id');
        });
    }
};
