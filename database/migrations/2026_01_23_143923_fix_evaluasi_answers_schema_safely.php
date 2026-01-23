<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('evaluasi_answers', function (Blueprint $table) {

            // ✅ PASTIKAN kolom question ADA
            if (!Schema::hasColumn('evaluasi_answers', 'question')) {
                $table->string('question')->nullable()->after('evaluasi_question_id');
            }

            // ✅ PASTIKAN kolom answer ADA
            if (!Schema::hasColumn('evaluasi_answers', 'answer')) {
                $table->text('answer')->nullable()->after('question');
            }

            // ❌ JANGAN SENTUH FOREIGN KEY DI SINI
            // FK SUDAH ADA → MENAMBAH ULANG = ERROR
        });
    }

    public function down(): void
    {
        // sengaja dikosongkan
        // migration ini hanya PERBAIKAN DB existing
    }
};
