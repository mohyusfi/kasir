<?php

namespace App\Livewire;

use Livewire\Component;

class CheckboxAll extends Component
{
    public $items = []; // Daftar item
    public $selected = []; // Item yang dipilih
    public $selectAll = false; // Status checkbox "Pilih Semua"

    public function mount()
    {
        // Contoh data (Bisa diambil dari database)
        $this->items = [
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
            ['id' => 3, 'name' => 'Item 3'],
            ['id' => 4, 'name' => 'Item 4'],
        ];
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = collect($this->items)->pluck('id')->toArray(); // Pilih semua
        } else {
            $this->selected = []; // Hapus semua
        }
    }

    public function updatedSelected()
    {
        $this->selectAll = count($this->selected) === count($this->items);
    }
    public function render()
    {
        return view('livewire.checkbox-all');
    }
}
