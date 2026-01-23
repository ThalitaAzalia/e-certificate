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
    Schema::table('certificate_templates', function (Blueprint $table) {

        if (!Schema::hasColumn('certificate_templates', 'aspect_ratio')) {
            $table->decimal('aspect_ratio', 5, 2)->nullable();
        }

        if (!Schema::hasColumn('certificate_templates', 'width_px')) {
            $table->integer('width_px')->nullable();
        }

        if (!Schema::hasColumn('certificate_templates', 'height_px')) {
            $table->integer('height_px')->nullable();
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('certificate_templates', function (Blueprint $table) {

        if (Schema::hasColumn('certificate_templates', 'aspect_ratio')) {
            $table->dropColumn('aspect_ratio');
        }

        if (Schema::hasColumn('certificate_templates', 'width_px')) {
            $table->dropColumn('width_px');
        }

        if (Schema::hasColumn('certificate_templates', 'height_px')) {
            $table->dropColumn('height_px');
        }

    });
}

};
