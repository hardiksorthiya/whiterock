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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            // Founder
        $table->string('founder_name')->nullable();
        $table->string('founder_designation')->nullable();
        $table->text('founder_description')->nullable();
        $table->string('founder_image')->nullable();

        // About Content
        $table->longText('description')->nullable();
        $table->longText('mission')->nullable();
        $table->longText('vision')->nullable();
        $table->longText('values')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
