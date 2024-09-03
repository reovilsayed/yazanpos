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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('trade_price')->nullable();
            $table->bigInteger('strip_price')->nullable();
            $table->bigInteger('box_price')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('order')->nullable();
            $table->integer('sold_unit')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('strength')->nullable();   
            $table->string('scrapper_url')->nullable();   
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('generic_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
