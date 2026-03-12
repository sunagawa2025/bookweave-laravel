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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            
            $table->string('isbn',13)->unique();
            

            $table->string('title',255);
            $table->string('author',255);

            
            /**
             * 未整理の本を許容するため、カテゴリーと出版社は任意入力（nullable）とする。
             */
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('publisher',255)->nullable();
            // 260211 datetime型で自動入力を設定しているため、仕様書上はNOT NULL(○)で管理。
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
