<?php

use App\Models\Doa;
use App\Models\DoaCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DoaCategory::class, "category_id");
            $table->string("title", 150)->default("-");
            $table->text("arabic")->default("-");
            $table->text("latin")->default("-");
            $table->text("translation")->default("-");
            $table->tinyInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doas');
    }
};
