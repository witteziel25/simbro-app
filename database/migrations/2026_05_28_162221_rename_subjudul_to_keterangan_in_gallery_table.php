<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->renameColumn('subjudul', 'keterangan');
        });
    }

    public function down()
    {
        Schema::table('gallery', function (Blueprint $table) {
            $table->renameColumn('keterangan', 'subjudul');
        });
    }
};
