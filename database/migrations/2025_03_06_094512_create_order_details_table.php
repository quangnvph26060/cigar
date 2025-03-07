<?php

use App\Models\Order;
use App\Models\PriceVariant;
use App\Models\Product;
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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->nullable()->constrained()->nullOnDelete();  // Add nullable() here
            $table->foreignIdFor(Product::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Variation::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(PriceVariant::class)->nullable()->constrained()->nullOnDelete();
            $table->string('p_name');
            $table->string('p_image');
            $table->decimal('p_price');
            $table->unsignedBigInteger('p_qty');
            $table->string('p_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
