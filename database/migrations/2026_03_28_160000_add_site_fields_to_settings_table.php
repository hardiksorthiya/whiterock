<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('id');
            $table->string('favicon_path')->nullable()->after('logo_path');
            $table->string('facebook_url')->nullable()->after('favicon_path');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('twitter_url')->nullable()->after('instagram_url');
            $table->string('whatsapp_url')->nullable()->after('twitter_url');
            $table->string('phone')->nullable()->after('whatsapp_url');
            $table->string('email')->nullable()->after('phone');
            $table->json('contact_locations')->nullable()->after('email');
            $table->text('footer_text')->nullable()->after('contact_locations');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'logo_path',
                'favicon_path',
                'facebook_url',
                'instagram_url',
                'twitter_url',
                'whatsapp_url',
                'phone',
                'email',
                'contact_locations',
                'footer_text',
            ]);
        });
    }
};
