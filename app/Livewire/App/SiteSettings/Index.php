<?php

namespace App\Livewire\App\SiteSettings;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;

class Index extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Site Settings')]

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function render()
    {
        return view('livewire.app.site-settings.index');
    }
}
