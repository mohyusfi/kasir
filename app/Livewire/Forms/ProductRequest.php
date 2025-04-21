<?php

namespace App\Livewire\Forms;

use App\Utils\ConvertString;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductRequest extends Form
{
    use ConvertString;
    public string $name = '';
    public string $description = '';
    public ?string $category = null;
    public int|string $quantity = 100;
    public string|null $color = '';
    public string|null $size = '';
    public string|float|null $purchasePrice = '';
    public string|float|null $price = '';

    public function formatPriceToNumber()
    {
        $this->price = $this->formatToNumber($this->price);
    }
    public function formatPurchasePriceToNumber()
    {
        $this->purchasePrice = $this->formatToNumber($this->purchasePrice);
    }

    public function resetField(array $properties = [
        'name',
        'description',
        'category',
        'quantity',
        'color',
        'size',
        'purchasePrice',
        'price'
    ] ): void
    {
        $this->reset($properties);
    }
}
