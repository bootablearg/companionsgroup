<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("coupons", function (Blueprint $table) {
            $table->id();
            $table->string("code", 50)->unique();
            $table->string("description", 300)->nullable();
            $table->enum("discount_type", ["percentage","fixed"])->default("percentage");
            $table->decimal("discount_value", 10, 2);
            $table->unsignedInteger("max_uses")->nullable();
            $table->unsignedInteger("used_count")->default(0);
            $table->foreignId("plan_id")->nullable()->constrained("subscription_plans")->nullOnDelete();
            $table->timestamp("expires_at")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("coupons"); }
};
