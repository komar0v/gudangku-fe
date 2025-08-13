<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Layanan extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Layanan Kami')]
    public function render()
    {
        return view('livewire.home.layanan');
    }
}
