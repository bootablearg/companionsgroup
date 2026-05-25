<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("rejection_reasons", function (Blueprint $table) {
            $table->id();
            $table->enum("context", ["aviso","kyc","review","user"]);
            $table->string("reason", 300);
            $table->boolean("is_active")->default(true);
            $table->unsignedSmallInteger("sort_order")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("rejection_reasons"); }
};
