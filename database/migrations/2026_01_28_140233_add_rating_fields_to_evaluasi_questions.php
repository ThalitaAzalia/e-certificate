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
        Schema::table('evaluasi_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluasi_questions', 'rating_min')) {
                $table->unsignedInteger('rating_min')->default(1)->after('type');
            }

            if (!Schema::hasColumn('evaluasi_questions', 'rating_max')) {
                $table->unsignedInteger('rating_max')->default(5)->after('rating_min');
            }

            if (!Schema::hasColumn('evaluasi_questions', 'rating_labels')) {
                $table->json('rating_labels')->nullable()->after('rating_max');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluasi_questions', function (Blueprint $table) {
            if (Schema::hasColumn('evaluasi_questions', 'rating_labels')) {
                $table->dropColumn('rating_labels');
            }
            if (Schema::hasColumn('evaluasi_questions', 'rating_max')) {
                $table->dropColumn('rating_max');
            }
            if (Schema::hasColumn('evaluasi_questions', 'rating_min')) {
                $table->dropColumn('rating_min');
            }
        });
    }

};
