<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductVariantRequest extends Form
{
    public int $productId;
    public string $color;
    public string $size;
    public float $price;
    public int $stock;
}
