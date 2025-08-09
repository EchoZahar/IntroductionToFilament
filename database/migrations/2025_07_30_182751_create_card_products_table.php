<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_nomenclature_id')->nullable();
            $table->unsignedBigInteger('ch_category_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('brand', 200);
            $table->string('article', 200);
            $table->string('unique_key', 200)->unique();
            $table->string('barcode')->nullable();
            $table->string('multiplicity', 10)->default('one');
            $table->integer('multiplicity_sale')->default(1);
            $table->string('status', 100);
            $table->string('expiration_date')->nullable();
            $table->string('tnved')->nullable();
            $table->string('okpd2')->nullable();
            $table->string('combine')->nullable()->comment('combine cards into one model');
            $table->string('group')->nullable()->comment('grouping cards by feature');
            $table->json('errors_or_exceptions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ch_category_id')->references('id')->on('ch_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_products');
    }
};
