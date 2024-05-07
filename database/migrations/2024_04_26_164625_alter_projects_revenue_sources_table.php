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
        Schema::rename('projects_revenue_sources', 'project_revenue_source');

        Schema::table('project_revenue_source', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->unsignedBigInteger('revenue_source_id')->change();

            $table->foreign('project_id')->on('projects')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('revenue_source_id')->on('revenue_sources')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_revenue_source', function (Blueprint $table) {
            $table->dropForeign('project_revenue_source_revenue_source_id_foreign');
            $table->dropForeign('project_revenue_source_project_id_foreign');
        });


        Schema::table('project_revenue_source', function (Blueprint $table) {
            $table->bigInteger('project_id')->change();
            $table->integer('revenue_source_id')->change();
        });

        Schema::rename('project_revenue_source', 'projects_revenue_sources');
    }
};
