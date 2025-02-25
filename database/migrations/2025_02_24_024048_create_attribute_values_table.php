<?php

use App\Models\Attribute;
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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();
            $table->string('value')->unique(); // Ví dụ: Mỹ, Hàn, Cohiba, Davidoff
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();

            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
