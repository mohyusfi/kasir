<?php

namespace App\Livewire;

use App\Models\Product;
use App\Utils\SearchProduct;
use Livewire\Component;

class DashboardPage extends Component
{
    use SearchProduct;
    public function render()
    {
        $resultSearch = $this->searchProduct();
        $products = $resultSearch->isNotEmpty() ? $resultSearch :
                    Product::select(['id', 'name', 'description', 'category_id'])
                                ->with(['category', 'variants'])
                                ->paginate(2);
        return view('livewire.dashboard-page', [
            'products' => $products
        ]);
    }
}
