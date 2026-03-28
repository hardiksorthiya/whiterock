<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku', 100)->unique();

            // Descriptions
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // ✅ IMPORTANT: match your table name
            $table->foreignId('category_id')
                  ->constrained('product_categories')
                  ->cascadeOnDelete();

            // Feature Image
            $table->string('featured_image')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};