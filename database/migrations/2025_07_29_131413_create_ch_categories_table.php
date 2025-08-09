<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ch_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->unsignedBigInteger('portal_id')->nullable();
            $table->boolean('is_active_on_ch')->default(false);
            $table->boolean('is_visible')->default(false);
            $table->integer('level')->default(0);
            $table->json('portal_ids')->nullable();
            $table->unsignedBigInteger('ya_category_id')->nullable();
            $table->unsignedBigInteger('wb_category_id')->nullable();
            $table->unsignedBigInteger('ozon_category_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ch_categories');
    }
};
