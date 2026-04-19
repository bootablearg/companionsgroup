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
        Schema::table('avisos', function (Blueprint $table) {
            $table->string('video_url_2')->nullable()->after('video_url');
            $table->string('video_url_3')->nullable()->after('video_url_2');
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['video_url_2', 'video_url_3']);
        });
    }
};
