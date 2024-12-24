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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->foreignId('product_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('measuring_unit_id')->constrained()->onDelete('cascade');
            $table->integer('qty_in_unit');
            $table->decimal('cost_price', 8, 2);
            $table->integer('discount')->default(0);
            $table->integer('markup_percentage')->default(0);
            $table->decimal('selling_price', 8, 2);
            $table->integer('stock_level_at_dispensary')->default(0);
            $table->integer('stock_level_at_store')->default(0);
            $table->integer('restock_level_at_dispensary')->default(0);
            $table->integer('restock_level_at_store')->default(0);
            $table->boolean('is_delisted')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('location_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('stock_level');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
