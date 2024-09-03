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
        Schema::create('purchase_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchased_unit')->constrained('units', 'id')->cascadeOnDelete();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->bigInteger('purchase_unit_quantity')->default(0);
            $table->bigInteger('purchase_quantity')->default(0);
            $table->bigInteger('remaining_quantity')->default(0);
            $table->bigInteger('supplier_rate')->default(0);
                
            $table->bigInteger('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_product');
    }
};
