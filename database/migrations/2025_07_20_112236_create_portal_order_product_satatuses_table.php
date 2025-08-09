<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_order_product_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->nullable();
            $table->unsignedBigInteger('ops_id')->comment('уникальный идентификатор статуса');
            $table->string('name')->comment('наименование статуса');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_order_product_statuses');
    }
};
