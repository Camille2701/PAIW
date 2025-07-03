<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Footer extends Component
{
    public $email = '';

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        // Logique d'inscription à la newsletter
        session()->flash('message', 'Merci pour votre inscription à notre newsletter !');
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.components.footer');
    }
}
