<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_no')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);

            $table->enum('payment_method', ['cash', 'card', 'bank_transfer'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('paid');
            $table->enum('status', ['completed', 'held', 'cancelled', 'refunded'])->default('completed');

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['customer_id']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};