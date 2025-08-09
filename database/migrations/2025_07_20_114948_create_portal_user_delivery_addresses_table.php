<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_user_delivery_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->nullable();
            $table->unsignedBigInteger('uda_id')->comment('уникальный идентификатор адреса доставки');
            $table->string('uuid')->comment('служебный идентификатор');
            $table->text('address')->comment('полный адрес доставки');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_user_delivery_addresses');
    }
};
