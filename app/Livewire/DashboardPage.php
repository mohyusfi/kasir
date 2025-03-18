<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class DashboardPage extends Component
{
    public function render()
    {
        return view('livewire.dashboard-page', [
            'products' => Product::select(['id', 'name', 'description', 'category_id'])
                                ->with(['category', 'variants'])
                                ->paginate(3)
        ]);
    }
}
