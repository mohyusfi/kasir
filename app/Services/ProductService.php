<?php


namespace App\Services;

use App\Livewire\Forms\ProductRequest;
use App\Models\Product;

interface ProductService {
    public function create(ProductRequest $product): Product;
    public function update(array $data, int $id): bool;
    public function delete(int $id, int $id_variant): void;
}