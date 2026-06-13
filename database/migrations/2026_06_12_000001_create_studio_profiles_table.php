<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studio_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('intro');
            $table->text('body');
            $table->text('vision');
            $table->string('image_one', 500)->nullable();
            $table->string('image_two', 500)->nullable();
            $table->text('architecture_text');
            $table->text('interiors_text');
            $table->text('landscape_text');
            $table->text('planning_text');
            $table->text('products_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studio_profiles');
    }
};
