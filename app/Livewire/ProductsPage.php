<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductsPage extends Component
{
    public ?Collection $products = null;

    public function mount()
    {
        $this->products = Product::get();
    }
    public function render()
    {
        return view('livewire.products-page');
    }
}
