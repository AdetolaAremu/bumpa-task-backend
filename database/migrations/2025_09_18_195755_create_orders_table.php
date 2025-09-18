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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_status', ['paid', 'pending', 'not_paid'])->default('not_paid');
            $table->enum('order_status', ['pending', 'shipped', 'completed', 'canceled'])->default('pending');
            $table->string('transaction_type')->nullable();
            $table->string('payment_reference');
            $table->boolean('cashback_unlocked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
