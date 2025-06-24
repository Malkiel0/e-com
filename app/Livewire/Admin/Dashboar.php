<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboar extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboar')->layout('layout.admin');
    }
}
