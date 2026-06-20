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
        Schema::create('admins', function (Blueprint $table) {
          $table->id(); 
$table->string('first_name', 100); 
$table->string('last_name', 100);
$table->string('username', 100)->unique();
$table->string('email', 150)->unique();
$table->string('phone', 20)->nullable(); 
$table->enum('gender', ['male', 'female', 'other'])->nullable(); 
$table->string('image')->nullable(); 
$table->timestamp('email_verified_at')->nullable(); 
$table->rememberToken();
$table->string('password'); 
$table->integer('status')->default(0); 
$table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
