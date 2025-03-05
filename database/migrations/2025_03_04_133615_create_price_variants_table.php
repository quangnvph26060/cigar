<?php

use App\Models\Variation;
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
        Schema::create('price_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Variation::class)->constrained()->cascadeOnDelete();
            $table->decimal('price');
            $table->decimal('discount_value')->nullable();
            $table->date('discount_start')->nullable();
            $table->date('discount_end')->nullable();
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_variants');
    }
};
