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
        Schema::create('discount_cupoms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameCupom');
            $table->decimal('discount', 8, 2);
            $table->date('validity');
            $table->integer('limitUse');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_cupoms');
    }
};
