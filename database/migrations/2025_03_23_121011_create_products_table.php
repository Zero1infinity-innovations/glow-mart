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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price',10,2);
            $table->enum('unit', ['Quantity', 'Gram', 'Kilogram', 'Milliliter', 'Liter']);
            $table->string('image');
            $table->json('multi_image')->nullable();
            $table->string('slug')->unique();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('status',['0','1'])->comment('0=inactive,1=active')->default(1); // Active or Inactive status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
