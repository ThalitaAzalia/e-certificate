<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            // TAMBAH KOLUMN BARU SETELAH "tanggal" (karena ini ADA)
            $table->time('waktu')->nullable();
            $table->string('narasumber')->nullable()->after('waktu');
            $table->string('media')->nullable()->after('narasumber');
        });
    }

    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn(['waktu', 'narasumber', 'media']);
        });
    }

};
