<?php

namespace App\Livewire;

use Illuminate\Mail\Transport\ArrayTransport;
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

    public function createProduct(): void
    {

    }

    public function render()
    {
        return view('livewire.form-input');
    }
}
