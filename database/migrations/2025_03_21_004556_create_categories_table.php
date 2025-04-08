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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_image', 255)->nullable();
            $table->string('category_name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('gmc_category', 255)->nullable();
            $table->enum('status',['0','1'])->comment('0=inactive,1=active')->default(1); // Active or Inactive status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
