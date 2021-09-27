<?php

namespace App\Http\Livewire\Client;

use App\Models\Mentor;
use App\Models\Plan;
use Livewire\Component;

class HomeUser extends Component
{
    public function render()
    {
        return view('livewire.client.home-user', [
            'plans' => Plan::all(),
            'mentors' => Mentor::limit(3)->get()
        ])->layout('layouts.user');
    }
}
