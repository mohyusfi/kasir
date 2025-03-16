<?php


namespace App\Services;

use App\Models\Product;

interface ProductService {
    public function create(array $data): Product;
    public function update(array $data, int $id): bool;
    public function delete(int $id): bool;
}