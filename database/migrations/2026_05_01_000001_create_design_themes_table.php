<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('colors_json');
            $table->json('typography_json');
            $table->json('custom_tokens_json')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_themes');
    }
};
