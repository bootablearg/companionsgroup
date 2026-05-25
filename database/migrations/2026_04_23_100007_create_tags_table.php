<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("tags", function (Blueprint $table) {
            $table->id();
            $table->string("name", 100)->unique();
            $table->string("slug", 110)->unique();
            $table->string("color", 7)->default("#C8A235");
            $table->boolean("is_active")->default(true);
            $table->unsignedSmallInteger("sort_order")->default(0);
            $table->timestamps();
        });
        Schema::create("aviso_tags", function (Blueprint $table) {
            $table->foreignId("aviso_id")->constrained()->cascadeOnDelete();
            $table->foreignId("tag_id")->constrained()->cascadeOnDelete();
            $table->primary(["aviso_id","tag_id"]);
        });
    }
    public function down(): void {
        Schema::dropIfExists("aviso_tags");
        Schema::dropIfExists("tags");
    }
};
