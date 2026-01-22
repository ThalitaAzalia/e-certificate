<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('file_name');
            $table->boolean('is_active')->default(false);

            $table->integer('pos_x')->default(50);
            $table->integer('pos_y')->default(55);
            $table->string('font_family')->default('Arial');
            $table->integer('font_size')->default(36);
            $table->string('font_color')->default('#000000');
            $table->string('font_weight')->default('700');
            $table->string('font_style')->default('normal');
            $table->integer('letter_spacing')->default(1);
            $table->decimal('line_height', 3, 2)->default(1.1);
            $table->string('text_align')->default('center');
            $table->decimal('aspect_ratio', 5, 2)->nullable();
            $table->boolean('is_recommended')->default(true);
            $table->integer('width_px')->nullable();
            $table->integer('height_px')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
