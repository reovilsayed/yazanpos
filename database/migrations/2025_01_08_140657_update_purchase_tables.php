<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Remove batch_name from purchases table
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('batch_name');
            $table->boolean('active')->default(false);
        });

        // Add batch_name to purchase_product table
        Schema::table('purchase_product', function (Blueprint $table) {
            $table->string('batch_name')->after('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Reverse the changes made in the 'up' method
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('batch_name')->nullable();
        });

        Schema::table('purchase_product', function (Blueprint $table) {
            $table->dropColumn('batch_name');
        });
    }
};
