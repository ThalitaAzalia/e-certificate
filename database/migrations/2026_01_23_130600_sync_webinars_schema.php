<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            // rename kolom EN → ID (kalau ada)
            if (Schema::hasColumn('webinars', 'title') && !Schema::hasColumn('webinars', 'judul')) {
                $table->renameColumn('title', 'judul');
            }

            if (Schema::hasColumn('webinars', 'description') && !Schema::hasColumn('webinars', 'deskripsi')) {
                $table->renameColumn('description', 'deskripsi');
            }

            if (Schema::hasColumn('webinars', 'date') && !Schema::hasColumn('webinars', 'tanggal')) {
                $table->renameColumn('date', 'tanggal');
            }

            // pastikan kolom yang dipakai aplikasi ADA
            if (!Schema::hasColumn('webinars', 'waktu')) {
                $table->time('waktu')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'narasumber')) {
                $table->string('narasumber')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'media')) {
                $table->string('media')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'poster')) {
                $table->string('poster')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'link_absensi')) {
                $table->string('link_absensi')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'link_detail')) {
                $table->string('link_detail')->nullable();
            }
        });
    }

    public function down(): void
    {
        // tidak perlu rollback, ini migration sinkronisasi
    }
};
