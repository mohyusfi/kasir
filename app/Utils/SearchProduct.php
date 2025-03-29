<?php

namespace App\Utils;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchProduct {
    public string $inputSearchProduct = '';

    public function searchProduct(): LengthAwarePaginator
    {
        if (Product::$categoryId === null) {
            return Product::select(['id', 'name', 'description', 'category_id'])
                                ->where('name', 'LIKE', '%' . $this->inputSearchProduct . '%')
                                ->with(['category', 'variants'])
                                ->paginate(3);
        } else {
            return Product::select(['id', 'name', 'description', 'category_id'])
                                ->filterByCategory()
                                ->where('name', 'LIKE', '%' . $this->inputSearchProduct . '%')
                                ->with(['category', 'variants'])
                                ->paginate(3);
        }
    }
}