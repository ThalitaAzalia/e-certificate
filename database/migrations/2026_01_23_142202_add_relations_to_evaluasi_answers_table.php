<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('evaluasi_answers', function (Blueprint $table) {

            if (!Schema::hasColumn('evaluasi_answers', 'webinar_id')) {
                $table->unsignedBigInteger('webinar_id')->after('peserta_id');
                $table->foreign('webinar_id')
                      ->references('id')->on('webinars')
                      ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('evaluasi_answers', 'evaluasi_question_id')) {
                $table->unsignedBigInteger('evaluasi_question_id')->after('webinar_id');
                $table->foreign('evaluasi_question_id')
                      ->references('id')->on('evaluasi_questions')
                      ->cascadeOnDelete();
            }

            if (Schema::hasColumn('evaluasi_answers', 'question')) {
                $table->dropColumn('question');
            }
        });
    }

    public function down(): void
    {
        Schema::table('evaluasi_answers', function (Blueprint $table) {

            if (Schema::hasColumn('evaluasi_answers', 'evaluasi_question_id')) {
                $table->dropForeign(['evaluasi_question_id']);
                $table->dropColumn('evaluasi_question_id');
            }

            if (Schema::hasColumn('evaluasi_answers', 'webinar_id')) {
                $table->dropForeign(['webinar_id']);
                $table->dropColumn('webinar_id');
            }

            if (!Schema::hasColumn('evaluasi_answers', 'question')) {
                $table->string('question')->nullable();
            }
        });
    }
};
