<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        // JIKA SUDAH ADA → JANGAN CREATE
        if (Schema::hasTable('evaluasi_questions')) {
            return;
        }

        Schema::create('evaluasi_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('type', ['rating', 'text'])->default('rating');
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('evaluasi_questions')) {
            Schema::drop('evaluasi_questions');
        }
    }
};
