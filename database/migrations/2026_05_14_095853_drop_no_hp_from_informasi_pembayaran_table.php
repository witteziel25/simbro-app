<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->dropColumn('no_hp');
        });
    }

    public function down()
    {
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $table->string('no_hp', 15)->nullable();
        });
    }
};
