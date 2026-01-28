<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('evaluasi_questions', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating_max')
                  ->default(5)
                  ->after('type');

            $table->json('rating_labels')
                  ->nullable()
                  ->after('rating_max');
        });
    }

    public function down()
    {
        Schema::table('evaluasi_questions', function (Blueprint $table) {
            $table->dropColumn(['rating_max', 'rating_labels']);
        });
    }
};
