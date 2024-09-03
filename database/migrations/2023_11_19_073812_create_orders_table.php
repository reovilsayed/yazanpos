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
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->bigInteger('sub_total');
            $table->bigInteger('discount');
            $table->bigInteger('total');
            $table->string('payment_method');
            $table->bigInteger('paid');
            $table->bigInteger('due');
            $table->bigInteger('profit');
            $table->enum('status', ['PAID', 'DUE', 'UNPAID',  'PENDING', 'REFUND']);
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
