<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            if (Schema::hasColumn('webinars', 'time')) {
                $table->dropColumn('time');
            }

            if (!Schema::hasColumn('webinars', 'waktu')) {
                $table->time('waktu')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            if (Schema::hasColumn('webinars', 'waktu')) {
                $table->dropColumn('waktu');
            }

            if (!Schema::hasColumn('webinars', 'time')) {
                $table->time('time')->nullable();
            }
        });
    }
};
