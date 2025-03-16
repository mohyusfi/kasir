<?php

namespace App\Services\ProductImpl;

use App\Models\Product;
use App\Services\ProductService;

class ProductServiceImpl implements ProductService {
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(array $data, int $id): bool
    {
        return true;
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);

        if (!is_null($product)) {
            $product->delete();
            return true;
        }

        return false;
    }
}