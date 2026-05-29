<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Cek apakah foreign key ada, jika ada hapus
        try {
            Schema::table('rekening_pembayaran', function (Blueprint $table) {
                $table->dropForeign(['informasi_id']);
            });
        } catch (\Exception $e) {
            // Foreign key mungkin sudah tidak ada, abaikan error
        }

        // Hapus kolom lama jika masih ada
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            $columns = Schema::getColumnListing('informasi_pembayaran');
            if (in_array('informasi_pembayaran', $columns)) {
                $table->dropColumn('informasi_pembayaran');
            }
            if (in_array('syarat_ketentuan', $columns)) {
                $table->dropColumn('syarat_ketentuan');
            }
            if (in_array('metode_pembayaran', $columns)) {
                $table->dropColumn('metode_pembayaran');
            }
            if (in_array('no_hp', $columns)) {
                $table->dropColumn('no_hp');
            }
        });

        // Tambah kolom judul dan deskripsi jika belum ada
        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('informasi_pembayaran', 'judul')) {
                $table->string('judul')->after('informasi_id');
            }
            if (!Schema::hasColumn('informasi_pembayaran', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
        });

        // Tambah foreign key kembali
        Schema::table('rekening_pembayaran', function (Blueprint $table) {
            $table->foreign('informasi_id')->references('informasi_id')->on('informasi_pembayaran')->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            Schema::table('rekening_pembayaran', function (Blueprint $table) {
                $table->dropForeign(['informasi_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('informasi_pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('informasi_pembayaran', 'judul')) {
                $table->dropColumn('judul');
            }
            if (Schema::hasColumn('informasi_pembayaran', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
            if (!Schema::hasColumn('informasi_pembayaran', 'informasi_pembayaran')) {
                $table->text('informasi_pembayaran')->nullable();
            }
            if (!Schema::hasColumn('informasi_pembayaran', 'syarat_ketentuan')) {
                $table->text('syarat_ketentuan')->nullable();
            }
        });

        Schema::table('rekening_pembayaran', function (Blueprint $table) {
            $table->foreign('informasi_id')->references('informasi_id')->on('informasi_pembayaran')->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
