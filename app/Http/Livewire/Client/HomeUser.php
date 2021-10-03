<?php

namespace App\Http\Livewire\Client;

use App\Models\Category;
use App\Models\Mentor;
use App\Models\Plan;
use App\Models\SubCategory;
use Livewire\Component;

class HomeUser extends Component
{
    public $show = false;
    public $query;
    public $selected = [];

    public function render()
    {
        return view('livewire.client.home-user', [
            'plans' => Plan::all(),
            'mentors' => Mentor::limit(3)->get(),
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ])->layout('layouts.user');
    }

    public function filter()
    {
        return redirect('mentor/' . base64_encode(json_encode(['data' => $this->selected, 'query' => $this->query])));
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }
}
