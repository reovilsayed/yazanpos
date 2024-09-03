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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('invoice')->nullable();
            $table->string('payment_type');
            $table->string('batch_name');
            $table->date('purcahsed_at');
            $table->string('details')->nullable();
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('vat')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('grand_total')->default(0);
            $table->bigInteger('paid_amount')->default(0);
            $table->bigInteger('due_amount')->default(0);
            $table->enum('status', ['PAID', 'DUE']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
