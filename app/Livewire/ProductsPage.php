<?php

namespace App\Livewire;

use App\Rules\CurrencyFormat;
use Exception;
use App\Models\Product;
use Livewire\Component;
use App\Utils\TraitSearch;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ProductVariant;
use Illuminate\Validation\Rule;
use App\Services\ProductService;
use App\Utils\TraitSearchCategory;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use App\Livewire\Forms\ProductRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\ProductVariantRequest;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function updatedProductRequestPrice($value): void
    {
        $this->productRequest->price = number_format((float)$value);
    }

    public function createProduct(ProductService $productService)
    {
        $this->productRequest->price = str_replace(',', '', $this->productRequest->price);
        try {
            DB::beginTransaction();
            $this->validate([
                'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
                'productRequest.description' => ['nullable', 'string'],
                'productRequest.quantity' => ['required', 'integer'],
                'productRequest.price' => ['required', 'numeric'],
                'productRequest.category' => ['required', 'string'],
                'productRequest.color' => ['nullable', 'string'],
                'productRequest.size' => ['nullable', 'string'],
            ]);


            $result = $productService->create($this->productRequest);

            $this->reset([
                'productRequest.name',
                'productRequest.description',
                'productRequest.quantity',
                'productRequest.price',
                'productRequest.category',
                'productRequest.color',
                'productRequest.size',
            ]);

            session()->flash("message", "success create " . $result->name);
            DB::commit();
        } catch (Exception|QueryException $exception) {
            DB::rollBack();
            $this->addError('variant', $exception->getMessage());
        }
    }

    public function updateProduct(ProductService $productService)
    {
        $this->validate([
            'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
            'productRequest.description' => ['nullable', 'string'],
            'productRequest.quantity' => ['required', 'integer', 'min:0'],
            'productRequest.price' => ['required', 'numeric', 'decimal:2', 'min:0'],
            'productRequest.category' => ['required', 'string'],
            'productRequest.color' => ['nullable', 'string'],
            'productRequest.size' => ['nullable', 'string'],
        ]);

        $productService->update($this->productRequest, $this->showEdit);

        session()->flash("message", "success update ". $this->productRequest->name);
    }

    public function deleteProductVariant(int $id_product, int $id_variant, ProductService $productService)
    {
        $productService->deleteProductVariant($id_product, $id_variant);
        $this->dispatch('refresh');
    }

    public function createProductVariant(int $productId, ProductService $productService): void
    {
        $this->productVariantRequest->productId = $productId;
        $this->validate([
            'productVariantRequest.productId' => ['required',
                Rule::unique('product_variants', 'product_id')->where(function(Builder $query) use ($productId){
                    $query->where('size', strtolower(trim($this->productVariantRequest->size)))
                            ->where('color', strtolower(trim($this->productVariantRequest->color)))
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
            $this->productRequest->quantity = $variant->stock;
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
            'products' => Product::select(['id', 'name', 'description', 'category_id', 'created_at'])
                                    ->with(['category', 'variants'])
                                    ->paginate(3),
            'deletedVariant' => ProductVariant::select('id')->onlyTrashed()->get()->count(),
        ]);
    }
}
