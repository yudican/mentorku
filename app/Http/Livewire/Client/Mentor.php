<?php

namespace App\Http\Livewire\Client;

use App\Models\Category;
use App\Models\Mentor as ModelsMentor;
use App\Models\SubCategory;
use Livewire\Component;

class Mentor extends Component
{
    public $selected = [];
    public $mentors = [];
    public function render()
    {
        if (($key = array_search(false, $this->selected)) !== false) {
            unset($this->selected[$key]);
        }

        if (count($this->selected) > 0) {
            $this->mentors = ModelsMentor::whereIn('subcategory_id', $this->selected)->get();
        } else {
            $this->mentors = ModelsMentor::all();
        }
        return view('livewire.client.mentor', [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ])->layout('layouts.user');
    }
}
