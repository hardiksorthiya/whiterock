<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $drop = array_filter([
            Schema::hasColumn('pages', 'breadcrumb_heading') ? 'breadcrumb_heading' : null,
            Schema::hasColumn('pages', 'breadcrumb_subtitle') ? 'breadcrumb_subtitle' : null,
        ]);

        if ($drop !== []) {
            Schema::table('pages', function (Blueprint $table) use ($drop) {
                $table->dropColumn($drop);
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('pages', 'breadcrumb_heading')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->string('breadcrumb_heading')->nullable()->after('hero_image');
            });
        }
        if (! Schema::hasColumn('pages', 'breadcrumb_subtitle')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->text('breadcrumb_subtitle')->nullable()->after('breadcrumb_heading');
            });
        }
    }
};
