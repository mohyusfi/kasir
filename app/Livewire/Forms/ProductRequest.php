<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductRequest extends Form
{
    public string $name;
    public string $description;
    public string $category;
    public string $stock;
    public ?string $color = null;
    public ?string $size = null;
    public string $price;
}
