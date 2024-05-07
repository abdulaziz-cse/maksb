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
        Schema::rename('projects_platforms', 'platform_project');

        Schema::table('platform_project', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->unsignedBigInteger('platform_id')->change();

            $table->foreign('project_id')->on('projects')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('platform_id')->on('platforms')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('platform_project', function (Blueprint $table) {
            $table->dropForeign('platform_project_platform_id_foreign');
            $table->dropForeign('platform_project_project_id_foreign');
        });


        Schema::table('platform_project', function (Blueprint $table) {
            $table->bigInteger('project_id')->change();
            $table->integer('platform_id')->change();
        });

        Schema::rename('platform_project', 'projects_platforms');
    }
};
