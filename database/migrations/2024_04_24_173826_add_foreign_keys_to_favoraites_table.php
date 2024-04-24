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
        Schema::table('favourites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('project_id')->change();

            $table->foreign('user_id')->on('users')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('project_id')->on('projects')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->dropForeign('favourites_project_id_foreign');
            $table->dropForeign('favourites_user_id_foreign');
        });

        Schema::table('favourites', function (Blueprint $table) {
            $table->bigInteger('project_id')->change();
            $table->bigInteger('user_id')->change();
        });
    }
};
