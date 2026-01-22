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
            $table->decimal('aspect_ratio', 5, 2)->nullable()->after('text_align');
            $table->boolean('is_recommended')->default(true)->after('aspect_ratio');
            $table->integer('width_px')->nullable()->after('is_recommended');
            $table->integer('height_px')->nullable()->after('width_px');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn([
                'aspect_ratio',
                'is_recommended',
                'width_px',
                'height_px',
            ]);
        });
    }
};
