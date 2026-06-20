<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->boolean('status')->default(true); // 1 = active
            $table->enum('product_type', ['simple', 'color', 'color_variant'])->default('simple');
            $table->integer('sale_price');
            $table->integer('previous_price')->nullable();
            $table->integer('purchase_price')->nullable();
            $table->string('barcode');
            $table->integer('stock'); 
            $table->string('tags')->nullable();
            $table->string('label')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->mediumText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
