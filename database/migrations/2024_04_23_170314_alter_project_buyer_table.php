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
        Schema::rename('projects_buyers', 'buyer_project');

        Schema::table('buyer_project', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->unsignedBigInteger('buyer_id')->change();

            $table->foreign('project_id')->on('projects')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('buyer_id')->on('buyers')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer_project', function (Blueprint $table) {
            $table->dropForeign('buyer_project_buyer_id_foreign');
            $table->dropForeign('buyer_project_project_id_foreign');
        });

        Schema::table('buyer_project', function (Blueprint $table) {
            $table->bigInteger('project_id')->change();
            $table->bigInteger('buyer_id')->change();
        });

        Schema::rename('buyer_project', 'projects_buyers');
    }
};
