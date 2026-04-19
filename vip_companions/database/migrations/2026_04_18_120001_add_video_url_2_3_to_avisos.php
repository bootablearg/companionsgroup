<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            if (!Schema::hasColumn('avisos', 'video_url_2')) {
                $table->string('video_url_2', 500)->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('avisos', 'video_url_3')) {
                $table->string('video_url_3', 500)->nullable()->after('video_url_2');
            }
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['video_url_2', 'video_url_3']);
        });
    }
};
