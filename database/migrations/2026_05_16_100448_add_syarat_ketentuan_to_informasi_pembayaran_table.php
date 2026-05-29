<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->text('syarat_ketentuan')->nullable()->after('informasi_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->dropColumn('syarat_ketentuan');
        });
    }
};
