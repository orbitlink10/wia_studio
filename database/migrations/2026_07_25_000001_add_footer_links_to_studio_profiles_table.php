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
            $table->text('footer_emails')->nullable()->after('phone_number');
            $table->text('footer_offices')->nullable()->after('footer_emails');
            $table->text('footer_socials')->nullable()->after('footer_offices');
            $table->text('footer_legal')->nullable()->after('footer_socials');
        });

        DB::table('studio_profiles')->update([
            'footer_emails' => "Studio: studio@wia.com",
            'footer_offices' => "Nairobi: +254 700 000 000",
            'footer_socials' => "Instagram: https://instagram.com\nLinkedIn: https://linkedin.com",
            'footer_legal' => "Privacy\nTerms",
        ]);
    }

    public function down(): void
    {
        Schema::table('studio_profiles', function (Blueprint $table) {
            $table->dropColumn(['footer_emails', 'footer_offices', 'footer_socials', 'footer_legal']);
        });
    }
};
