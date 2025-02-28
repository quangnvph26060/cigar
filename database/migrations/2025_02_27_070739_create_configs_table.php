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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();
            $table->string('hotline')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('introduction')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('copyright')->nullable();
            $table->string('restriction_message')->nullable();
            $table->string('adult_only_policy')->nullable();

            $table->string('title')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
