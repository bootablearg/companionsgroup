<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("escort_profiles", function (Blueprint $table) {
            $table->smallInteger("penis_length_cm")->unsigned()->nullable()->after("hip_cm");
            $table->smallInteger("penis_girth_cm")->unsigned()->nullable()->after("penis_length_cm");
        });
    }

    public function down(): void
    {
        Schema::table("escort_profiles", function (Blueprint $table) {
            $table->dropColumn(["penis_length_cm", "penis_girth_cm"]);
        });
    }
};
