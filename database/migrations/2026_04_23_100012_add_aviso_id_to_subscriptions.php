<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('aviso_id')->nullable()->after('plan_id');
            $table->foreign('aviso_id')
                  ->references('id')->on('avisos')
                  ->onDelete('restrict');
            $table->index('aviso_id');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['aviso_id']);
            $table->dropIndex(['aviso_id']);
            $table->dropColumn('aviso_id');
        });
    }
};
