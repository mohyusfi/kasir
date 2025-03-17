<?php

namespace App\Services\ProductImpl;

use App\Livewire\Forms\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ProductService;

class ProductServiceImpl implements ProductService {
    public function create(ProductRequest $product): Product
    {
        $categoryId = Category::select("id")
                ->where("name", strtolower(trim($product->category)))
                ->first()->id;

        if ($categoryId == null) {
            $category = Category::create(['name' => strtolower($product->category)]);
            $categoryId = $category->id;
        }

        $result = Product::create([
            'name' => $product->name,
            'description' => $product->description,
            'category_id' => $categoryId,
        ]);

        $productId = $result->id;

        ProductVariant::create([
            'product_id' => $productId,
            'color' => $product->color,
            'size' => $product->size,
            'price' => $product->price,
            'stock' => $product->stock,
        ]);

        return $result;
    }

    public function update(array $data, int $id): bool
    {
        return true;
    }

    public function delete(int $id_product, int $id_variant): void
    {
        $product = Product::find($id_product);

        if (!is_null($product)) {
            ProductVariant::find($id_variant)?->delete();
        }

        $jmlVariant = $product->variants->count();

        if ($jmlVariant < 1) {
            $product->delete();
        }
    }
}