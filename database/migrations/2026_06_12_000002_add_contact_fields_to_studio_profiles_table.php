<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('studio_profiles', function (Blueprint $table) {
            $table->string('contact_email', 160)->nullable()->after('image_two');
            $table->string('phone_number', 80)->nullable()->after('contact_email');
        });

        DB::table('studio_profiles')->update([
            'contact_email' => 'studio@wia.com',
            'phone_number' => '+254 700 000 000',
        ]);
    }

    public function down(): void
    {
        Schema::table('studio_profiles', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'phone_number']);
        });
    }
};
