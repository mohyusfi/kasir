<?php

namespace App\Livewire;

use App\Services\ProductService;
use Illuminate\Mail\Transport\ArrayTransport;
use Livewire\Attributes\On;
use Livewire\Component;

class FormInput extends Component
{
    public array $input = [];
    public array $fields;
    public string $method;

    public function mount(
        array $fields,
        string $method,
    ): void
    {
        $this->fields = $fields;
        $this->method = $method;
        foreach ($fields as $key => $value) {
            $this->input[$key] = $value['default'] ?? '';
        }
    }

    public function createProduct(ProductService $productService)
    {
        $product = $this->validate([
            'input.name' => ['required', 'string', 'min:3', 'max:100'],
            'input.description' => ['nullable', 'string'],
            'input.quantity' => ['required', 'integer'],
            'input.price' => ['required', 'integer'],
            'input.category' => ['required', 'string'],
        ]);

        $category = $product['input']['category'];
        unset($product['input']['category']);

        $productService->create($product['input']);

        session()->flash('message', 'success create data');
    }

    #[On('send-category')]
    public function setCategory($category): void
    {
        $this->input['category'] = $category;
    }

    public function render()
    {
        return view('livewire.form-input');
    }
}
