<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('pages', 'breadcrumb_crumbs')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('breadcrumb_crumbs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pages', 'breadcrumb_crumbs')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->json('breadcrumb_crumbs')->nullable()->after('breadcrumb_subtitle');
        });
    }
};
