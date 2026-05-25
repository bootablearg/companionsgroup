<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->string('alias', 100)->nullable()->after('title');
            $table->tinyInteger('age')->unsigned()->nullable()->after('alias');
            $table->string('gender', 20)->default('female')->after('age');
            $table->string('sexual_orientation', 50)->nullable()->after('gender');
            $table->string('nationality', 100)->nullable()->after('sexual_orientation');
            // Appearance
            $table->string('hair_color', 50)->nullable()->after('nationality');
            $table->string('eye_color', 50)->nullable()->after('hair_color');
            $table->string('skin_color', 50)->nullable()->after('eye_color');
            $table->smallInteger('height_cm')->unsigned()->nullable()->after('skin_color');
            $table->decimal('weight_kg', 5, 1)->nullable()->after('height_cm');
            $table->smallInteger('bust_cm')->unsigned()->nullable()->after('weight_kg');
            $table->smallInteger('waist_cm')->unsigned()->nullable()->after('bust_cm');
            $table->smallInteger('hip_cm')->unsigned()->nullable()->after('waist_cm');
            $table->smallInteger('penis_length_cm')->unsigned()->nullable()->after('hip_cm');
            $table->smallInteger('penis_girth_cm')->unsigned()->nullable()->after('penis_length_cm');
            $table->boolean('is_smoker')->default(false)->after('penis_girth_cm');
            $table->boolean('is_waxed')->default(false)->after('is_smoker');
            $table->boolean('has_tattoos')->default(false)->after('is_waxed');
            $table->boolean('has_piercings')->default(false)->after('has_tattoos');
            // Contact
            $table->string('contact_phone', 30)->nullable()->after('has_piercings');
            $table->string('contact_whatsapp', 30)->nullable()->after('contact_phone');
            $table->string('contact_telegram', 30)->nullable()->after('contact_whatsapp');
            $table->string('contact_email', 255)->nullable()->after('contact_telegram');
            $table->string('contact_instagram', 255)->nullable()->after('contact_email');
            $table->string('contact_tiktok', 255)->nullable()->after('contact_instagram');
            $table->string('contact_onlyfans', 255)->nullable()->after('contact_tiktok');
            $table->boolean('show_whatsapp')->default(true)->after('contact_onlyfans');
            $table->boolean('show_telegram')->default(true)->after('show_whatsapp');
            $table->boolean('show_email')->default(false)->after('show_telegram');
            $table->boolean('show_instagram')->default(true)->after('show_email');
            $table->boolean('show_tiktok')->default(true)->after('show_instagram');
            $table->boolean('show_onlyfans')->default(true)->after('show_tiktok');
            // Location IDs
            $table->unsignedBigInteger('country_id')->nullable()->after('show_onlyfans');
            $table->unsignedBigInteger('province_id')->nullable()->after('country_id');
            $table->unsignedBigInteger('city_id')->nullable()->after('province_id');
            $table->string('city_name', 255)->nullable()->after('city_id');
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn([
                'alias','age','gender','sexual_orientation','nationality',
                'hair_color','eye_color','skin_color','height_cm','weight_kg',
                'bust_cm','waist_cm','hip_cm','penis_length_cm','penis_girth_cm',
                'is_smoker','is_waxed','has_tattoos','has_piercings',
                'contact_phone','contact_whatsapp','contact_telegram','contact_email',
                'contact_instagram','contact_tiktok','contact_onlyfans',
                'show_whatsapp','show_telegram','show_email','show_instagram','show_tiktok','show_onlyfans',
                'country_id','province_id','city_id','city_name',
            ]);
        });
    }
};
