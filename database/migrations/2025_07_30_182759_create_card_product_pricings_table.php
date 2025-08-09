<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_product_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_product_id');
            $table->float('cost_price');
            $table->float('market_price')->nullable();
            $table->float('vip_three')->nullable();
            $table->float('three_price')->nullable();
            $table->bigInteger('original_price');
            $table->string('currency_code', 20)->default('RUB');
            $table->string('vat', 5)->default('0.2');
            $table->timestamps();
            $table->foreign('card_product_id')->references('id')->on('card_products')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_product_pricing');
    }
};
