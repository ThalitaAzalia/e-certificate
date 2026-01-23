<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToWebinarsTable extends Migration
{
    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            if (!Schema::hasColumn('webinars', 'status')) {
                $table->enum('status', ['draft', 'published'])
                      ->default('draft');
            }

            if (!Schema::hasColumn('webinars', 'poster')) {
                $table->string('poster')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'link_absensi')) {
                $table->string('link_absensi')->nullable();
            }

            if (!Schema::hasColumn('webinars', 'link_detail')) {
                $table->string('link_detail')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            if (Schema::hasColumn('webinars', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('webinars', 'poster')) {
                $table->dropColumn('poster');
            }

            if (Schema::hasColumn('webinars', 'link_absensi')) {
                $table->dropColumn('link_absensi');
            }

            if (Schema::hasColumn('webinars', 'link_detail')) {
                $table->dropColumn('link_detail');
            }

        });
    }
}
