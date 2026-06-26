<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->string('expense_no')->unique();
            $table->foreignId('expense_category_id')->constrained('expense_categories')->onDelete('restrict');

            $table->date('expense_date');
            $table->decimal('amount', 12, 2);

            $table->enum('payment_method', ['cash', 'card', 'bank_transfer'])->default('cash');
            $table->string('payment_reference')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable(); // optional receipt/bill upload

            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['expense_category_id']);
            $table->index(['expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};