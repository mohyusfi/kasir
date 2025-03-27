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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->nullable(false);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->timestamps();
            $table->foreign('category_id', 'fk_category_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->string('color', 100)->nullable();
            $table->string('size', 100)->nullable();
            $table->decimal('price', 20, 2)->nullable(false);
            $table->unsignedInteger('stock')->nullable(false)->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id')->nullable(false);
            $table->unsignedBigInteger('totalPrice')->nullable(false)->default(0);
            $table->enum('status', ['pending', 'completed', 'failed'])
                        ->nullable(false)->default('pending');
            $table->timestamps();
            $table->foreign('cashier_id', 'fk_cashier_id')->references('id')->on('users');
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->nullable(false);
            $table->unsignedBigInteger('variant_id')->nullable(false);
            $table->unsignedInteger('quantity')->nullable(false)->default(0);
            $table->decimal('sub_total', 10)->nullable(false)->default(0);
            $table->timestamps();
            $table->unique(['transaction_id', 'variant_id']);
            $table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreign('variant_id')->references('id')->on('product_variants')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
    }
};
