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
        Schema::create('tb_logradouro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_user');
            $table->string('type');
            $table->string('zip_code');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('number');
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logradouros');
    }
};
