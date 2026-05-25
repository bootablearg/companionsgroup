<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aviso_videos', function (Blueprint $table) {
            $table->enum('type', ['url', 'file'])->default('url')->after('aviso_id');
            $table->string('thumb_path', 500)->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('aviso_videos', function (Blueprint $table) {
            $table->dropColumn(['type', 'thumb_path']);
        });
    }
};
