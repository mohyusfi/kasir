<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Utils\TraitSearch;
use Livewire\Attributes\On;
use App\Services\ProductService;
use App\Livewire\Forms\ProductRequest;
use Illuminate\Database\Eloquent\Collection;

class ProductsPage extends Component
{
    use TraitSearch;
    public ProductRequest $productRequest;
    public ?Collection $products = null;
    public ?int $showEdit = null;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function createProduct(ProductService $productService)
    {
        $product = $this->validate([
            'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
            'productRequest.description' => ['nullable', 'string'],
            'productRequest.stock' => ['required', 'integer'],
            'productRequest.price' => ['required', 'integer'],
            'productRequest.category' => ['required', 'string'],
            'productRequest.color' => ['nullable', 'string'],
            'productRequest.size' => ['nullable', 'string'],
        ]);

        dd($product);
    }


    public function deleteProduct(int $id, ProductService $productService)
    {
        $productService->delete($id);
        $this->dispatch('refresh');
    }

    public function setProduct(int $id): void
    {
        $this->showEdit == $id ? $this->showEdit = null : $this->showEdit = $id;
        if ($this->showEdit !== null) {
            $product = Product::find($id);
            $this->productRequest->name = $product->name;
            $this->productRequest->description = $product->description;
        }
    }

    #[On('refresh')]
    public function loadComponent(): void
    {
        $this->products = Product::all();
        $this->dispatch('$refresh');
    }
    public function render()
    {
        return view('livewire.products-page');
    }
}
