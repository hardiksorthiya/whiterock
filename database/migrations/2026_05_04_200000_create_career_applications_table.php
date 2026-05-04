<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 255);
            $table->string('phone', 40);
            $table->string('years_experience', 80)->nullable();
            $table->string('education', 255)->nullable();
            $table->string('position', 255)->nullable();
            $table->text('hire_why')->nullable();
            $table->string('cv_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
