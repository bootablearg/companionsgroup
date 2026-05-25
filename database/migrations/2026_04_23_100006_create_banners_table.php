<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("banners", function (Blueprint $table) {
            $table->id();
            $table->string("title", 200);
            $table->text("message");
            $table->enum("type", ["info","warning","success","promo"])->default("info");
            $table->enum("target", ["all","modelos","subscribers","guests"])->default("all");
            $table->string("cta_text", 100)->nullable();
            $table->string("cta_url", 500)->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamp("starts_at")->nullable();
            $table->timestamp("ends_at")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("banners"); }
};
