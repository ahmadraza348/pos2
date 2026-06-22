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

            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->text('description')->nullable();

            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('profit_margin', 5, 2)->default(20); // percentage
            $table->decimal('selling_price', 12, 2)->default(0);

            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(0);

            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('restrict');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('restrict');
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('restrict');

            $table->string('image')->nullable();
            $table->boolean('status')->default(true);

            // Useful additions for a POS system
            $table->boolean('is_featured')->default(false);
            $table->softDeletes(); // your model already uses SoftDeletes — column was missing

            $table->timestamps();

            // Helpful for fast POS lookups/search
            $table->index(['name']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};