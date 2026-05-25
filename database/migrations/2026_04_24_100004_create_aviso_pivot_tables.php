<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aviso_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained()->cascadeOnDelete();
            $table->string('language', 50);
            $table->enum('level', ['native', 'professional', 'intermediate', 'basic'])->default('intermediate');
        });

        Schema::create('aviso_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_type_id')->constrained()->cascadeOnDelete();
            $table->string('value', 255)->nullable();
        });

        Schema::create('aviso_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained()->cascadeOnDelete();
            $table->string('duration', 50);
            $table->decimal('price_usd', 10, 2);
            $table->string('currency', 3)->default('USD');
        });

        Schema::create('aviso_weekly_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week')->unsigned();
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aviso_weekly_schedules');
        Schema::dropIfExists('aviso_rates');
        Schema::dropIfExists('aviso_services');
        Schema::dropIfExists('aviso_languages');
    }
};
