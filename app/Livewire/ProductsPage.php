<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Component;
use App\Utils\TraitSearch;
use Livewire\Attributes\On;
use App\Services\ProductService;
use App\Livewire\Forms\ProductRequest;
use App\Livewire\Forms\ProductVariantRequest;
use App\Utils\TraitSearchCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductsPage extends Component
{
    use TraitSearchCategory, WithPagination, WithoutUrlPagination;
    public ProductRequest $productRequest;
    public ProductVariantRequest $productVariantRequest;
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
            'productRequest.price' => ['required', 'decimal'],
            'productRequest.category' => ['required', 'string'],
            'productRequest.color' => ['nullable', 'string'],
            'productRequest.size' => ['nullable', 'string'],
        ]);

        $result = $productService->create($this->productRequest);

        session()->flash("message", "success create " . $result->name);
    }

    public function updateProduct(ProductService $productService)
    {
        $this->validate([
            'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
            'productRequest.description' => ['nullable', 'string'],
            'productRequest.stock' => ['required', 'integer'],
            'productRequest.price' => ['required', 'numeric', 'decimal:2', 'min:0'],
            'productRequest.category' => ['required', 'string'],
            'productRequest.color' => ['nullable', 'string'],
            'productRequest.size' => ['nullable', 'string'],
        ]);

        $productService->update($this->productRequest, $this->showEdit);

        $this->dispatch('$refresh');

        session()->flash("message", "success update ". $this->productRequest->name);
    }

    public function deleteProduct(int $id_product, int $id_variant, ProductService $productService)
    {
        $productService->delete($id_product, $id_variant);
        $this->dispatch('refresh');
    }

    public function createProductVariant(int $productId, ProductService $productService): void
    {
        $this->productVariantRequest->productId = $productId;
        $this->validate([
            'productVariantRequest.productId' => ['required',
                Rule::unique('product_variants', 'product_id')->where(function(Builder $query){
                    $query->where('size', $this->productVariantRequest->size)
                            ->where('color', $this->productVariantRequest->color)
                            ->where('stock', $this->productVariantRequest->stock)
                            ->where('price', $this->productVariantRequest->price);
                })
            ],
            'productVariantRequest.stock' => ['required', 'integer', 'min:0'],
            'productVariantRequest.price' => ['required', 'numeric', 'decimal:2', 'min:0'],
            'productVariantRequest.color' => ['nullable', 'string'],
            'productVariantRequest.size' => ['nullable', 'string'],
        ]);

        $variant = $productService->createVariant($this->productVariantRequest);
        $this->reset('productVariantRequest');
        session()->flash("message", "success add variant product : " . $variant->product->name);
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
            $this->productRequest->category = $category->name;
            $this->productRequest->stock = $variant->stock;
            $this->productRequest->size = $variant->size;
            $this->productRequest->price = $variant->price;
        } else {
            $this->product_id = null;
            $this->productRequest->name = '';
            $this->reset('productRequest');
            $this->search = '';
        }
    }


    #[On('refresh')]
    public function loadComponent(): void
    {
        $this->dispatch('$refresh');
    }

    protected function messages()
    {
        return [
            'productVariantRequest.productId.unique' => 'this variant already exists'
        ];
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
