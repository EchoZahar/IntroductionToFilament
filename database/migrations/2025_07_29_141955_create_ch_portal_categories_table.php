<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ch_portal_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ch_category_id')->nullable();
            $table->unsignedBigInteger('ch_portal_id')->nullable();
            $table->unsignedBigInteger('portal_id');
            $table->unsignedBigInteger('portal_parent_id');
            $table->unsignedBigInteger('portal_root_id');
            $table->string('name')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ch_portal_categories');
    }
};
