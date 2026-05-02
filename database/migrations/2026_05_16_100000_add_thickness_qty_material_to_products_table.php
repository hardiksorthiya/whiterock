<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('thickness')->nullable()->after('installation');
            $table->string('qty')->nullable()->after('thickness');
            $table->string('material')->nullable()->after('qty');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['thickness', 'qty', 'material']);
        });
    }
};
