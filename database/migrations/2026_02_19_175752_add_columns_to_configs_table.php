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
        Schema::table('configs', function (Blueprint $table) {
            // 組織・会社情報
            $table->string('company_name')->nullable()->after('mail_from_name'); // 会社名
            $table->string('address')->nullable()->after('company_name'); // 住所
            $table->string('phone_number')->nullable()->after('address'); // 電話番号
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'address', 'phone_number']);
        });
    }
};
