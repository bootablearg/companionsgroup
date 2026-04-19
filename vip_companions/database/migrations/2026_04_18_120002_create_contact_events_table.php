<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('aviso_id')->constrained('avisos')->cascadeOnDelete();
            $table->enum('type', ['email', 'phone', 'whatsapp', 'telegram']);
            $table->timestamp('contacted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_events');
    }
};
