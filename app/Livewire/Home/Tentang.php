<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Tentang extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Tentang')]
    public function render()
    {
        return view('livewire.home.tentang');
    }
}
