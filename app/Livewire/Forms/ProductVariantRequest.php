<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductVariantRequest extends Form
{
    public int $productId;
    public ?string $color = null;
    public ?string $size = null;
    public string $price = '';
    public int $stock = 0;
}
