<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{

    #[Layout('layouts.layout-home')]
    public function render()
    {
        return view('livewire.home-page');
    }
}
