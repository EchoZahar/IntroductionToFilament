<?php

use App\Models\Marketplace;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Marketplace::class);
            $table->string('name', 100)->comment('Store (market) name.');
            $table->string('slug', 120)->unique();
            $table->json('credentials')->comment('Credentials you market on marketplace.');
            $table->boolean('is_active')->default(false)->comment('Turn off or turn on market');
            $table->json('contacts')->nullable()->comment('Contact owner info.');
            $table->string('portal_hash')->nullable()->comment('This hash is needed to connect to the portal.');
            $table->foreignId('created_by');
            $table->foreignId('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('modified_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};
