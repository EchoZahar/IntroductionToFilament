<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_user_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->nullable();
            $table->unsignedBigInteger('ua_id')->comment('идентификатор договора, основной, уникальный (agreement_id)');
            $table->string('uuid')->comment('дополнительный служебный идентификатор');
            $table->string('name')->comment('наименование договора');
            $table->decimal('credit', 14, 2)->comment('кредитный лимит по договору, р.');
            $table->decimal('balance', 14, 2)->comment('остаток средств по договору');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_user_agreements');
    }
};
