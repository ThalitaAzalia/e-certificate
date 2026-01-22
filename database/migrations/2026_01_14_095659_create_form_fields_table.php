<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();

            // mapping ke kolom pesertas
            $table->string('field_key'); 
            // contoh: nama_peserta, email, no_hp

            $table->string('label');
            // contoh: Nama Lengkap, Email Aktif

            $table->string('type');
            // text, email, number, select, textarea, dll

            $table->boolean('required')->default(false);
            $table->boolean('active')->default(true);

            $table->integer('sort_order')->default(0);

            // opsional (placeholder / catatan admin)
            $table->string('placeholder')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
