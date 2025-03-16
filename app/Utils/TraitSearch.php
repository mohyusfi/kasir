<?php

namespace App\Utils;

use App\Models\Category;

trait TraitSearch {
    public string $search;
    public ?array $result = null;
    public array $myAttribute;
    public string $keyInput = '';

    public function updatedSearch(string $value): void
    {
        if (!empty(trim($value))) {
            $result =  Category::select('name')
                                        ->where("name", "LIKE", '%'. $value . '%')
                                        ->get()
                                        ->toArray();
        }
        $this->result = $result ?? [];
        $this->productRequest->category = $value;
    }

    public function sendValue(string $name): void
    {
        $this->search = $name;
        $this->keyInput = uniqid();
        $this->result = [];
        $this->productRequest->category = $name;
    }
}