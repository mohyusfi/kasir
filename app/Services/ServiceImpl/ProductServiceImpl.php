<?php

namespace App\Services\ServiceImpl;

use App\Livewire\Forms\ProductRequest;
use App\Livewire\Forms\ProductVariantRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ProductService;
use Exception;

class ProductServiceImpl implements ProductService {
    public function create(ProductRequest $product): Product
    {
        $categoryId = Category::select("id")
                ->where("name", strtolower(trim($product->category)))
                ->first()?->id;

        if ($categoryId == null) {
            $category = Category::create(['name' => strtolower($product->category)]);
            $categoryId = $category->id;
        }

        $result = Product::create([
            'name' => $product->name,
            'description' => $product->description,
            'category_id' => $categoryId,
        ]);

        $isVariantExists = ProductVariant::select('id')
                                        ->where('product_id', $result->id)
                                        ->where('size', $product->size)
                                        ->where('color', $product->color)
                                        ->where('price', $product->price)
                                        ->first();
        if ($isVariantExists !== null) {
            throw new Exception('variant already exists');
        }

        $productId = $result->id;

        ProductVariant::create([
            'product_id' => $productId,
            'color' => $product->color,
            'size' => $product->size,
            'price' => $product->price,
            'stock' => $product->quantity,
        ]);

        return $result;
    }

    public function createVariant(ProductVariantRequest $productVariantRequest): ProductVariant
    {
        return ProductVariant::create([
            'product_id' => $productVariantRequest->productId,
            'stock' => $productVariantRequest->stock,
            'size' => $productVariantRequest->size,
            'color' => $productVariantRequest->color,
            'price' => $productVariantRequest->price,
        ]);
    }

    public function update(ProductRequest $product, int $id_variant): void
    {
        $productVariant = ProductVariant::find($id_variant);

        $category_id = Category::select("id")
                                ->where("name",
                                strtolower(trim($product->category)))
                                ->first()?->id;

        if ($category_id == null) {
            $category = Category::create([
                'name' => strtolower(trim($product->category))
            ]);
            $category_id = $category->id;
        }

        $productVariant->product()->update([
            "name" => $product->name,
            "description" => $product->description,
            "category_id" => $category_id,
        ]);

        $productVariant->update([
            "color" => $product->color,
            "size" => $product->size,
            "price" => $product->price,
            "stock" => $product->quantity,
        ]);
    }

    public function deleteProductVariant(int $id_product, int $id_variant): void
    {
        $product = Product::find($id_product);

        if (!is_null($product)) {
            ProductVariant::find($id_variant)?->delete();
        }
    }

    public function restoreProductVariant(int $id_variant): void
    {
        $variant = ProductVariant::select('id')
                                    ->onlyTrashed()
                                    ->where('id', $id_variant);
        if ($variant !== null) {
            $variant->restore();
        }
    }
}