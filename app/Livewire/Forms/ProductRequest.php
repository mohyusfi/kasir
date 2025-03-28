<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductRequest extends Form
{
    public ?string $name = null;
    public ?string $description = null;
    public ?string $category = null;
    public int $quantity = 100;
    public ?string $color = null;
    public ?string $size = null;
    public ?string $price = null;
}
