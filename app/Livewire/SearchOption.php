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

    public function updatedSearch($value)
    {
        if (!empty(trim($value))) {
            $result =  Category::select('name')
                                        ->where("name", "LIKE", '%'. $value . '%')
                                        ->get()
                                        ->toArray();
        }
        $this->result = $result ?? [];
    }

    public function sendValue(string $name): void
    {
        $this->search = $name;
        $this->result = [];
    }

    public function render()
    {
        return view('livewire.search-option');
    }
}
