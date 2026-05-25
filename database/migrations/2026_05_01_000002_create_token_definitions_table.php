<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('token_name')->unique();
            $table->enum('category', ['color', 'typography', 'spacing', 'other'])->default('color');
            $table->text('description')->nullable();
            $table->json('affects')->nullable()->comment('JSON array de ubicaciones donde se usa');
            $table->json('validation_rules')->nullable();
            $table->string('example_value')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('token_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_definitions');
    }
};
