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
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('vat')->nullable();
            // $table->boolean('is_bonus')->default(false);
            $table->enum('is_bonus',[
                'Rate Product',
                'Bonus Product',
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('vat')->nullable();
            $table->dropColumn('is_bonus')->nullable();
        });
    }
};
