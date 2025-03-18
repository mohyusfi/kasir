<?php

namespace App\Utils;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchProduct {
    public string $inputSearchProduct;

    public function searchProduct(): LengthAwarePaginator
    {
        return Product::select(['id', 'name', 'description', 'category_id'])
                            ->where('name', 'LIKE', '%' . $this->inputSearchProduct . '%')
                            ->with(['category', 'variants'])
                            ->paginate(3);
    }
}