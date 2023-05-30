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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('name');
            $table->string('phone');
            $table->string('pin_code');
            $table->text('address');
            $table->enum('payment_method', array('cod', 'midtrans'));
            $table->unsignedInteger('food_id');
            $table->unsignedInteger('costumer_id');
            $table->bigInteger('amount');
            $table->timestamp("order_placed_at")->useCurrent();
            $table->text('description');
            $table->string('snap_token')->nullable();
            $table->enum('status', array('pending', 'success', 'expired', 'failed'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
