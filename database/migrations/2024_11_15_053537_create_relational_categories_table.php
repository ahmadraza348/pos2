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
    Schema::create('relational_categories', function (Blueprint $table) {
        $table->id();
        
        // Product relation with cascade deletion (deletes pivot row if product is deleted)
        $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
        
        // Attribute relation with cascade deletion (deletes pivot row if attribute is deleted)
        $table->foreignId('attribute_id')->nullable()->constrained()->onDelete('cascade');
        
        // Brand relation with cascade deletion (deletes pivot row if brand is deleted)
        $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
        
        // Category relation WITHOUT cascade deletion (keeps category intact)
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('restrict');
        
        // Polymorphic relation fields
        $table->unsignedBigInteger('metaable_id');
        $table->string('metaable_type'); 
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relational_categories');
    }
};
