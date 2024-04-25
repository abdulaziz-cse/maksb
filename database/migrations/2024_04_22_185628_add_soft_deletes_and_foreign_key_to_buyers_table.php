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
        Schema::table('buyers', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->after('id')->nullable()->change();

            $table->foreign('user_id')->on('users')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropForeign('buyers_user_id_foreign');
        });

        Schema::table('buyers', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable(false)->change();
            $table->dropSoftDeletes();
        });
    }
};
