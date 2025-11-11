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
        Schema::create('product_shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkShoppingCart');
            $table->unsignedInteger('fkProduct');
            $table->integer('quantity');
            $table->unsignedInteger('fkColor');
            $table->unsignedInteger('fkSize');
            $table->foreign('fkShoppingCart')->references('id')->on('shopping_cart')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shopping_carts');
    }
};
