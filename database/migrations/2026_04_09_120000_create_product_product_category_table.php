<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_product_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'product_category_id']);
        });

        $rows = DB::table('products')
            ->whereNotNull('category_id')
            ->select('id', 'category_id')
            ->get();

        $now = now();
        foreach ($rows as $row) {
            DB::table('product_product_category')->insert([
                'product_id' => $row->id,
                'product_category_id' => $row->category_id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_product_category');
    }
};
