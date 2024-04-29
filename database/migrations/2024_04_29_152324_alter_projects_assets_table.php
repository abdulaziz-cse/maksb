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
        Schema::rename('projects_assets', 'asset_project');

        Schema::table('asset_project', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->unsignedBigInteger('asset_id')->change();

            $table->foreign('project_id')->on('projects')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('asset_id')->on('assets')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_project', function (Blueprint $table) {
            $table->dropForeign('asset_project_asset_id_foreign');
            $table->dropForeign('asset_project_project_id_foreign');
        });


        Schema::table('asset_project', function (Blueprint $table) {
            $table->bigInteger('project_id')->change();
            $table->integer('asset_id')->change();
        });

        Schema::rename('asset_project', 'projects_assets');
    }
};
