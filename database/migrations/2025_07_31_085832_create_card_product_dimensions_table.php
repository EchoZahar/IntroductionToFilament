<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_product_dimensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_product_id');
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
            $table->string('dimension_unit', 3)->default('mm');
            $table->integer('net_weight');
            $table->integer('gross_weight');
            $table->string('weight_unit', 4)->default('g');
            $table->float('volume',  6)->nullable();
            $table->float('volume_weight',  6)->nullable();
            $table->float('volume_liter',  6)->nullable();
            $table->boolean('is_kgt')->default(false);

            $table->timestamps();
            $table->foreign('card_product_id')->references('id')->on('card_products')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_product_dimensions');
    }
};
