<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->integer('width_px')->nullable()->after('file_name');
            $table->integer('height_px')->nullable()->after('width_px');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn(['width_px', 'height_px']);
        });
    }
};
