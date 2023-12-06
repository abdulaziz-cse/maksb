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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->integer('type_id');
            $table->integer('category_id');
            $table->string('website');
            $table->date('establishment_date');
            $table->integer('country_id');
            $table->string('other_platform')->nullable();
            $table->integer('currency_id');
            $table->boolean('yearly');
            $table->json('incoming');
            $table->json('cost');
            $table->json('revenue');
            $table->json('expenses');
            $table->string('other_assets')->nullable();
            $table->boolean('is_supported');
            $table->string('support')->nullable();
            $table->json('social_media');
            $table->string('email_subscribers');
            $table->string('other_social_media')->nullable();
            $table->string('short_description');
            $table->text('description');
            $table->string('video_url')->nullable();
            $table->string('price');
            $table->integer('package_id');
            $table->json('billing_info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
