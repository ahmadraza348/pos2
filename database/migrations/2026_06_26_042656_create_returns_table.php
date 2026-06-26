<?php
// create_returns_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();

            $table->string('return_no')->unique();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('restrict');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');

            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->enum('refund_method', ['cash', 'card', 'bank_transfer', 'store_credit'])->default('cash');
            $table->boolean('restocked')->default(true);

            $table->text('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['sale_id']);
            $table->index(['customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};