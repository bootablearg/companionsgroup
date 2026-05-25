<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_links', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['whatsapp', 'telegram', 'discord']);
            $table->enum('type', ['support', 'bot', 'group', 'channel']);
            $table->string('label');
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('contact_links');
    }
};
