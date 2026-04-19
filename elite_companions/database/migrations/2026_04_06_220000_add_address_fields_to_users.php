<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('street', 150)->nullable()->after('neighborhood');
            $table->string('street_number', 20)->nullable()->after('street');
            $table->string('floor_apt', 30)->nullable()->after('street_number');
            $table->string('postal_code', 20)->nullable()->after('floor_apt');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['street', 'street_number', 'floor_apt', 'postal_code']);
        });
    }
};
