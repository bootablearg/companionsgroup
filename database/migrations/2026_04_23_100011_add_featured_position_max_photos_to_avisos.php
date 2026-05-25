<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('avisos', function (Blueprint $table) {
            $table->unsignedSmallInteger('featured_position')->nullable()->after('featured_until');
            $table->unsignedSmallInteger('max_photos')->nullable()->after('featured_position');
        });
    }
    public function down(): void {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['featured_position', 'max_photos']);
        });
    }
};
