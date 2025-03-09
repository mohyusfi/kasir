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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->nullable(false)->default(0);
            $table->unsignedBigInteger('price')->nullable(false)->default(0);
            $table->timestamps();
        });


        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->foreign('product_id', 'fk_product_id')->references('id')->on('products');
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamp('sold_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('totalPrice')->nullable(false)->default(0);
            $table->unsignedBigInteger('cashier_id')->nullable(false);
            $table->foreign('cashier_id', 'fk_cashier_id')->references('id')->on('users');
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->unsignedInteger('quantity')->nullable(false)->default(0);
            $table->unsignedBigInteger('sub_total')->nullable(false)->default(0);
            $table->timestamps();
            $table->unique(['sale_id', 'product_id']);
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
    }
};
