<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('overview_image', 500)->nullable()->after('hero_image');
            $table->string('spatial_image', 500)->nullable()->after('summary');
            $table->string('material_image', 500)->nullable()->after('spatial_image');
            $table->string('delivery_image', 500)->nullable()->after('material_image');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['overview_image', 'spatial_image', 'material_image', 'delivery_image']);
        });
    }
};
