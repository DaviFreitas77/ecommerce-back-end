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
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_product');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('fk_order');
            $table->decimal('total', 10, 2);
            $table->unsignedInteger('fk_color');
            $table->unsignedInteger('fk_size');

            $table->foreign('fk_color')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('fk_size')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('fk_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('fk_order')->references('id')->on('tb_order')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
