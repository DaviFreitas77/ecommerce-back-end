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
        Schema::create('cupom_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_user');
            $table->unsignedInteger('fk_cupom');
            $table->unsignedInteger('fk_order');
            $table->decimal('value', 8, 2);
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_cupom')->references('id')->on('discount_cupoms')->onDelete('cascade');
            $table->foreign('fk_order')->references('id')->on('tb_order')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupom_users');
    }
};
