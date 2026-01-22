<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToWebinarsTable extends Migration
{
    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {

            $table->enum('status', ['draft', 'published'])
                  ->default('draft')
                  ->after('media');

            $table->string('poster')->nullable()->after('status');

            $table->string('link_absensi')->nullable()->after('poster');
            $table->string('link_detail')->nullable()->after('link_absensi');

        });
    }

    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'poster',
                'link_absensi',
                'link_detail',
            ]);
        });
    }
}
