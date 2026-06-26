<?php
// create_return_items_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('return_id')->constrained('returns')->onDelete('cascade');
            $table->foreignId('sale_item_id')->constrained('sale_items')->onDelete('restrict');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');

            $table->string('product_name');
            $table->string('product_sku');
            $table->decimal('unit_price', 12, 2);
            $table->integer('quantity_returned');
            $table->decimal('total', 12, 2);

            $table->timestamps();

            $table->index(['return_id']);
            $table->index(['sale_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};