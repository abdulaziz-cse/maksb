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
            $table->renameColumn('consultant_type', 'consultant_type_id');
        });

        Schema::table('buyers', function (Blueprint $table) {
            $table->unsignedBigInteger('consultant_type_id')->change();
            $table->unsignedBigInteger('status_id')->change();

            $table->foreign('consultant_type_id')->on('predefined_values')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('status_id')->on('predefined_values')->references('id')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropForeign(['consultant_type_id']);
            $table->dropForeign(['status_id']);
        });

        Schema::table('buyers', function (Blueprint $table) {
            $table->integer('consultant_type_id')->change();
            $table->integer('status_id')->change();
        });

        Schema::table('buyers', function (Blueprint $table) {
            $table->renameColumn('consultant_type_id', 'consultant_type');
        });
    }
};
