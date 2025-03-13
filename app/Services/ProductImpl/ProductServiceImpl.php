<?php

namespace App\Services\ProductImpl;

use App\Models\Product;
use App\Services\ProductService;

class ProductServiceImpl implements ProductService {
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(): bool
    {
        return true;
    }

    public function delete(): bool
    {
        return true;
    }
}