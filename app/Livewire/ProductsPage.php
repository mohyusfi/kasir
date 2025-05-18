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
use App\Utils\ConvertString;
use App\Utils\UseFormInput;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsPage extends Component
{
    use TraitSearchCategory, WithPagination, WithoutUrlPagination, ConvertString, UseFormInput;
    public ProductRequest $productRequest;
    public ProductVariantRequest $productVariantRequest;
    public ?int $showEdit = null;
    public ?int $product_id = null;

    public function mount()
    {
        Product::select(['id', 'name', 'description', 'category_id'])
            ->with(['category', 'variants'])
            ->paginate(5);
        $this->productRequest->description = 'perume di sukai cewek';
        $this->productRequest->name = "perfume wangy";
        $this->productRequest->color = "red";
        $this->productRequest->size = "60ml";
        $this->productRequest->price = "100,000.00";
        $this->productRequest->purchasePrice = "120,000.00";
    }

    public function createProduct(ProductService $productService)
    {
        $this->productRequest->formatPriceToNumber();
        $this->productRequest->formatPurchasePriceToNumber();

        try {
            DB::beginTransaction();
            $this->validate([
                'productRequest.name' => ['required', 'string', 'min:3', 'max:100', 'unique:products,name'],
                'productRequest.description' => ['nullable', 'string'],
                'productRequest.quantity' => ['required', 'integer'],
                'productRequest.category' => ['required', 'string'],
                'productRequest.price' => ['required', 'numeric'],
                'productRequest.purchasePrice' => ['required', 'numeric'],
                'productRequest.color' => ['nullable', 'string'],
                'productRequest.size' => ['nullable', 'string'],
            ]);

            $result = $productService->create($this->productRequest);

            $this->productRequest->resetField();
            $this->resetCategory();

            session()->flash("message", "success create " . $result->name);
            DB::commit();
        } catch (Exception | QueryException $exception) {
            DB::rollBack();
            $this->productRequest->price = number_format($this->productRequest->price, 2);
            $this->productRequest->purchasePrice = number_format($this->productRequest->purchasePrice, 2);
            $this->addError('variant', $exception->getMessage());
        }
    }

    public function updateProduct(ProductService $productService)
    {
        $this->productRequest->formatPriceToNumber();
        $this->productRequest->formatPurchasePriceToNumber();

        try {
            DB::beginTransaction();
            $this->validate([
                'productRequest.name' => ['required', 'string', 'min:3', 'max:100'],
                'productRequest.description' => ['nullable', 'string'],
                'productRequest.quantity' => ['required', 'integer', 'min:0'],
                'productRequest.price' => ['required', 'numeric'],
                'productRequest.purchasePrice' => ['required', 'numeric'],
                'productRequest.category' => ['required', 'string'],
                'productRequest.color' => ['nullable', 'string'],
                'productRequest.size' => ['nullable', 'string'],
            ]);

            $productService->update($this->productRequest, $this->showEdit);

            $this->resetCategory();

            session()->flash("message", "success update " . $this->productRequest->name);
            DB::commit();
        } catch (Exception | QueryException $exception) {
            DB::rollBack();
            $this->productRequest->price = number_format($this->productRequest->price, 2);
            $this->productRequest->purchasePrice = number_format($this->productRequest->purchasePrice, 2);
            $this->addError('variant', $exception->getMessage());
        }
    }

    public function deleteProductVariant(int $id_product, int $id_variant, ProductService $productService)
    {
        $productService->deleteProductVariant($id_product, $id_variant);
    }

    public function createProductVariant(int $productId, ProductService $productService): void
    {
        $this->productVariantRequest->productId = $productId;
        $this->productVariantRequest->formatPriceToNumber();
        $this->productVariantRequest->formatPurchasePriceToNumber();

        $this->validate([
            'productVariantRequest.productId' => [
                'required',
                Rule::unique('product_variants', 'product_id')->where(function (Builder $query) use ($productId) {
                    $query->where('size', strtolower(trim($this->productVariantRequest->size)))
                        ->where('color', strtolower(trim($this->productVariantRequest->color)))
                        ->where('price', $this->productVariantRequest->price);
                })
            ],
            'productVariantRequest.stock' => ['required', 'integer', 'min:0'],
            'productVariantRequest.price' => ['required', 'numeric'],
            'productRequest.purchasePrice' => ['required', 'numeric'],
            'productVariantRequest.color' => ['nullable', 'string'],
            'productVariantRequest.size' => ['nullable', 'string'],
        ]);

        $variant = $productService->createVariant($this->productVariantRequest);

        $this->productVariantRequest->resetField();

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
            $this->productRequest->category = $category->name;
            $this->productRequest->quantity = $variant->stock;
            $this->productRequest->size = $variant->size;
            $this->productRequest->price = number_format($variant->price, 2);
            $this->productRequest->purchasePrice = number_format($variant->purchasePrice, 2);

            $this->search = $category->name;
        } else {
            $this->product_id = null;
            $this->productRequest->name = '';
            $this->productRequest->resetField();
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
            'productVariantRequest.productId.unique' => 'variant ini sudah ada',
            'productRequest.name.required' => "Harus ada nama product",
            'productRequest.name.unique' => "Nama Product Telah Digunakan",
            'productRequest.price.required' => "price harus di ini",
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
