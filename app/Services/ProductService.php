<?php


namespace App\Services;

use App\Livewire\Forms\ProductRequest;
use App\Livewire\Forms\ProductVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;

interface ProductService {
    public function create(ProductRequest $product): Product;
    public function createVariant(ProductVariantRequest $productVariantRequest): ProductVariant;
    public function update(ProductRequest $product, int $id_variant): void;
    public function deleteProductVariant(int $id_product, int $id_variant): void;
    public function restoreProductVariant(int $id_variant): void;
}