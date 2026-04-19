<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->after('phone')
                ->comment('Telegram chat_id numérico — se registra cuando el usuario inicia el bot');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telegram_chat_id');
        });
    }
};
