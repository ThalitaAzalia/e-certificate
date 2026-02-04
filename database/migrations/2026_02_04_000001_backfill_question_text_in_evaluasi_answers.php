<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Backfill question_text for existing answers that still reference a question
        // Use a single SQL update for efficiency
        DB::statement("UPDATE evaluasi_answers AS ea
            JOIN evaluasi_questions AS q ON ea.evaluasi_question_id = q.id
            SET ea.question_text = q.question
            WHERE ea.evaluasi_question_id IS NOT NULL
              AND (ea.question_text IS NULL OR ea.question_text = '')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // revert by nulling the values we set (only where there is still a referenced question)
        DB::statement("UPDATE evaluasi_answers AS ea
            JOIN evaluasi_questions AS q ON ea.evaluasi_question_id = q.id
            SET ea.question_text = NULL
            WHERE ea.evaluasi_question_id IS NOT NULL");
    }
};
