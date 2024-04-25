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
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('yearly')->nullable()->change();
            $table->json('incoming')->nullable()->change();
            $table->json('cost')->nullable()->change();
            $table->json('revenue')->nullable()->change();
            $table->string('email_subscribers')->nullable()->change();
            $table->integer('package_id')->nullable()->change();
            $table->json('billing_info')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('yearly')->nullable(false)->change();
            $table->json('incoming')->nullable(false)->change();
            $table->json('cost')->nullable(false)->change();
            $table->json('revenue')->nullable(false)->change();
            $table->string('email_subscribers')->nullable(false)->change();
            $table->integer('package_id')->nullable(false)->change();
            $table->json('billing_info')->nullable(false)->change();
        });
    }
};
