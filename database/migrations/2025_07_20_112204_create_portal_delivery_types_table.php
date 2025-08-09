<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_delivery_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->nullable();
            $table->unsignedBigInteger('dt_id')->comment('уникальный идентификатор типа доставки');
            $table->string('name')->comment('наименование типа доставки');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_delivery_types');
    }
};
