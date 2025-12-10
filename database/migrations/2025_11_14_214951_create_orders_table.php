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
        Schema::create('tb_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_order');
            $table->unsignedInteger('fk_user');
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'canceled',
                'preparando',
                'entregue',
            ])->default('pending');
            $table->decimal('total', 10, 2);
            $table->string('payment_method')->nullable();
            $table->unsignedInteger('fk_cupom')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_cupom')->references('id')->on('discount_cupoms')->onDelete('set null');
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
