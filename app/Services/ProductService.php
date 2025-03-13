<?php


namespace App\Services;

use App\Models\Product;

interface ProductService {
    public function create(array $data): Product;
    public function update(): bool;
    public function delete(): bool;
}