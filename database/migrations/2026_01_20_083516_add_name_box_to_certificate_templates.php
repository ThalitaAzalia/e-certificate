<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('certificate_templates', function (Blueprint $table) {
        $table->float('box_x')->default(40);      // kiri (%)
        $table->float('box_y')->default(55);      // atas (%)
        $table->float('box_width')->default(40);  // lebar (%)
        $table->float('box_height')->default(10); // tinggi (%)
    });
}

public function down()
{
    Schema::table('certificate_templates', function (Blueprint $table) {
        $table->dropColumn([
            'box_x',
            'box_y',
            'box_width',
            'box_height',
        ]);
    });
}

};
