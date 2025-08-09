<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->nullable();
            $table->unsignedBigInteger('wh_id')->comment('уникальный идентификатор склада');
            $table->string('name', 100)->comment('наименование склада');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_warehouses');
    }
};
