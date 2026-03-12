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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();

            /**
             * データの整合性を保つため、外部キー制約（foreignId）に変更。
             */
            $table->foreignId('stock_id')->constrained();
            $table->foreignId('user_id')->constrained();
            

            $table->date('borrowed_at');

            
            $table->date('returned_at')->nullable();
            
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
