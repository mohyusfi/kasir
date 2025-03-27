<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ProductVariant;
use App\Services\ProductService;

class DeletedProductVariant extends Component
{
    public function restoreVariant(int $id_variant, ProductService $productService): void
    {
        $productService->restoreProductVariant($id_variant);
        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function loadComponent(): void
    {
        $this->dispatch('$refresh');
    }
    public function render()
    {
        $productVariants = ProductVariant::select(['id', 'product_id', 'color', 'size', 'price', 'stock'])
                            ->whereHas('product')
                            ->with('product')
                            ->onlyTrashed()
                            ->get();
        return view('livewire.deleted-product-variant', [
            'products' => $productVariants
        ]);
    }
}
