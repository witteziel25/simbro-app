<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('m_users', function (Blueprint $table) {
            $table->dropColumn('peran');
        });
    }

    public function down()
    {
        Schema::table('m_users', function (Blueprint $table) {
            $table->enum('peran', ['peternak', 'rumah_pemotongan'])->nullable()->after('alamat');
        });
    }
};
