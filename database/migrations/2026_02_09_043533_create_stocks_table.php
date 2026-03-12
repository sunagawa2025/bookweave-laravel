<?php

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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('management_id',36);
            /**
             * データの整合性を保つため、外部キー制約（foreignId）に変更。
             */
            $table->foreignId('book_id')->constrained();
            
            $table->string('status',20);

            //datetime型で自動入力を設定しているため、仕様書上はNOT NULL(○)で管理。
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
