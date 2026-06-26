<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('price');
            $table->string('category')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->string('img')->nullable();
            $table->text('description')->nullable();
            $table->string('dimensions')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->float('rating')->default(0);
            $table->boolean('customizable')->default(false);
            $table->unsignedBigInteger('base_price')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
