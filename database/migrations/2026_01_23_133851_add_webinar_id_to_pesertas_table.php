<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            if (!Schema::hasColumn('pesertas', 'webinar_id')) {
                $table->foreignId('webinar_id')
                      ->constrained('webinars')
                      ->cascadeOnDelete()
                      ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            if (Schema::hasColumn('pesertas', 'webinar_id')) {
                $table->dropForeign(['webinar_id']);
                $table->dropColumn('webinar_id');
            }
        });
    }
};
