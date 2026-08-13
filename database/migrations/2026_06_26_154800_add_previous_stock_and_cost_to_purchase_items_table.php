<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * These snapshot the product's stock and cost_price immediately BEFORE
     * this item was applied (i.e. at the moment the purchase was marked
     * "received"). They let a later cancellation restore the product to
     * exactly what it was before this purchase — instead of just reversing
     * the stock quantity and leaving a stale weighted-average cost behind.
     *
     * Left null for items that never moved stock (purchase stayed pending)
     * and for rows created before this migration existed.
     */
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->integer('previous_stock')->nullable()->after('unit_cost');
            $table->decimal('previous_cost_price', 12, 2)->nullable()->after('previous_stock');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['previous_stock', 'previous_cost_price']);
        });
    }
};
