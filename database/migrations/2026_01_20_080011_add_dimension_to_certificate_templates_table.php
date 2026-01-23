<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('certificate_templates', function (Blueprint $table) {

        if (!Schema::hasColumn('certificate_templates', 'width_px')) {
            $table->integer('width_px')->nullable();
        }

        if (!Schema::hasColumn('certificate_templates', 'height_px')) {
            $table->integer('height_px')->nullable();
        }

    });
}


    public function down(): void
{
    Schema::table('certificate_templates', function (Blueprint $table) {

        if (Schema::hasColumn('certificate_templates', 'width_px')) {
            $table->dropColumn('width_px');
        }

        if (Schema::hasColumn('certificate_templates', 'height_px')) {
            $table->dropColumn('height_px');
        }

    });
}

};
