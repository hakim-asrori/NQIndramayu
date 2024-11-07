<?php

use App\Models\Maulid;
use App\Models\MaulidCategory;
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
        Schema::create('maulid_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Maulid::class)->references('id')->on('maulids')->cascadeOnDelete();
            $table->text("arabic")->default("-");
            $table->text("latin")->default("-");
            $table->text("translation")->default("-");
            $table->text("transliteration")->default("-");
            $table->text("barrier")->default("-");
            $table->tinyInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maulid_contents');
    }
};
