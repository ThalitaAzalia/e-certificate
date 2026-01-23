<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {

            if (!Schema::hasColumn('pesertas', 'nama_peserta')) {
                $table->string('nama_peserta')->nullable();
            }

            if (!Schema::hasColumn('pesertas', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('pesertas', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }

            if (!Schema::hasColumn('pesertas', 'waktu_absen')) {
                $table->timestamp('waktu_absen')->nullable();
            }
        });
    }

    public function down(): void
    {
        // rollback tidak wajib untuk sinkronisasi
    }
};
