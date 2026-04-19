<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('aviso_id')->constrained('avisos')->cascadeOnDelete();
            $table->string('type')->default('view'); // view, whatsapp, telegram, phone, email
            $table->timestamps();

            $table->index(['subscriber_id', 'created_at']);
            $table->index(['aviso_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_events');
    }
};
