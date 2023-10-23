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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->smallInteger('type_id');
            $table->text('about')->nullable();
            $table->string('purchase_purpose')->nullable();
            $table->string('budget')->nullable();
            $table->string('favorite_value')->nullable();
            $table->string('profession')->nullable();
            $table->string('owner_of')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('website')->nullable();
            $table->string('photo')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
