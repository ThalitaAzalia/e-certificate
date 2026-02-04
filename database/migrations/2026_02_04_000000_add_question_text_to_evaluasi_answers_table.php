<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('evaluasi_answers', function (Blueprint $table) {
            $table->text('question_text')->nullable()->after('evaluasi_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluasi_answers', function (Blueprint $table) {
            $table->dropColumn('question_text');
        });
    }
};
