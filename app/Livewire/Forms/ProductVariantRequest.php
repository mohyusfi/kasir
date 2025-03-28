<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductVariantRequest extends Form
{
    public ?int $productId = null;
    public ?string $color = null;
    public ?string $size = null;
    public ?string $price = null;
    public int $stock = 0;
}
