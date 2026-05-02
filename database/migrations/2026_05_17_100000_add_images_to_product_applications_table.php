<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_applications', function (Blueprint $table) {
            $table->string('feature_image')->nullable()->after('name');
            $table->string('banner_image')->nullable()->after('feature_image');
        });
    }

    public function down(): void
    {
        Schema::table('product_applications', function (Blueprint $table) {
            $table->dropColumn(['feature_image', 'banner_image']);
        });
    }
};
