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
        Schema::table('verification_codes', function (Blueprint $table) {
            $table->string('code')->nullable()->change();
            $table->string('status')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verification_codes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};