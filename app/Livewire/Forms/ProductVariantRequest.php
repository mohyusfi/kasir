<?php

namespace App\Livewire\Forms;

use App\Utils\ConvertString;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductVariantRequest extends Form
{
    use ConvertString;
    public int|null|string $productId = null;
    public string $color = '';
    public string $size = '';
    public string|float $purchasePrice = '';
    public string|float $price = '';
    public int|string $stock = 0;

    public function formatPriceToNumber()
    {
        $this->price = $this->formatToNumber($this->price);
    }
    public function formatPurchasePriceToNumber()
    {
        $this->purchasePrice = $this->formatToNumber($this->purchasePrice);
    }

    public function resetField(): void
    {
        $this->reset([
            'productId',
            'color',
            'size',
            'purchasePrice',
            'price',
            'stock'
        ]);
    }
}
