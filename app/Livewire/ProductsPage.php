<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Component;
use App\Utils\TraitSearch;
use Livewire\Attributes\On;
use App\Services\ProductService;
use App\Livewire\Forms\ProductRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductsPage extends Component
{
    use TraitSearch, WithPagination, WithoutUrlPagination;
    public ProductRequest $productRequest;
    // public $products = null;
    public ?int $showEdit = null;
    public ?int $product_id = null;

    public function mount()
    {
        Product::select(['id', 'name', 'description', 'category_id'])
                                ->with(['category', 'variants'])
                                ->paginate(5);
    }

    public function createProduct(ProductService $productService)
    {
        $this->validate([
            'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
            'productRequest.description' => ['nullable', 'string'],
            'productRequest.stock' => ['required', 'integer'],
            'productRequest.price' => ['required', 'numberic'],
            'productRequest.category' => ['required', 'string'],
            'productRequest.color' => ['nullable', 'string'],
            'productRequest.size' => ['nullable', 'string'],
        ]);

        $result = $productService->create($this->productRequest);

        session()->flash("message", "success create " . $result->name);
    }

    public function updateProduct()
    {
        dd(['variant_id' => $this->showEdit, 'product_id' => $this->product_id]);
    }

    public function deleteProduct(int $id_product, int $id_variant, ProductService $productService)
    {
        $productService->delete($id_product, $id_variant);
        $this->dispatch('refresh');
    }

    public function setProduct(int $id): void
    {
        $this->showEdit == $id ? $this->showEdit = null : $this->showEdit = $id;
        if ($this->showEdit !== null) {
            $variant = ProductVariant::find($id);
            $product = $variant->product;
            $category = $product->category;
            $this->product_id = $product->id;
            $this->productRequest->name = $product->name;
            $this->productRequest->description = $product->description;
            $this->search = $category->name;
            $this->productRequest->stock = $variant->stock;
            $this->productRequest->size = $variant->size;
            $this->productRequest->price = $variant->price;
        }
    }


    #[On('refresh')]
    public function loadComponent(): void
    {
        // $this->products = Product::all();
        $this->dispatch('$refresh');
    }
    public function render()
    {
        return view('livewire.products-page', [
            'products' => Product::select(['id', 'name', 'description', 'category_id'])
            ->with(['category', 'variants'])
            ->paginate(3)
        ]);
    }
}
