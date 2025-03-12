<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SearchOption extends Component
{
    public string $search;
    public ?array $result = null;
    public array $myAttribute;
    public string $key = '';


    public function mount(
        array $myAttribute = [
            'placeholder' => 'masukkan category',
        ],
    ): void
    {
        $this->myAttribute = $myAttribute;
        $myAttribute['default'] ? $this->search = $myAttribute['default'] : '';
    }

    public function updatedSearch($value): void
    {
        if (!empty(trim($value))) {
            $result =  Category::select('name')
                                        ->where("name", "LIKE", '%'. $value . '%')
                                        ->get()
                                        ->toArray();
        }
        $this->result = $result ?? [];
        $this->dispatch('send-category', category: $value);
    }

    public function sendValue(string $name): void
    {
        $this->search = $name;
        $this->key = $name;
        $this->result = [];
        $this->dispatch('send-category', category: $name);
    }

    public function render()
    {
        return view('livewire.search-option');
    }
}
