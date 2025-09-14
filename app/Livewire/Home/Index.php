<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Index extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Emping Merapi')]

    public function render()
    {
        return view('livewire.home.index');
    }
}
