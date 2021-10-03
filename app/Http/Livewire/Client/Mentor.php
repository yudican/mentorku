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
    public $query;

    protected $listeners = ['setSelected'];

    public function mount($search = null)
    {
        $data = json_decode(base64_decode($search), true);

        $this->selected = $data['data'];
        $this->query = $data['query'];
    }
    public function render()
    {
        if (($key = array_search(false, $this->selected)) !== false) {
            unset($this->selected[$key]);
        }

        if (count($this->selected) > 0) {
            $search = $this->query;
            $this->mentors = ModelsMentor::whereIn('subcategory_id', $this->selected)->whereHas('user', function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->get();
        } else if ($this->query) {
            $search = $this->query;
            $this->mentors = ModelsMentor::whereHas('user', function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->get();
        } else {
            $this->mentors = ModelsMentor::all();
        }
        return view('livewire.client.mentor', [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ])->layout('layouts.user');
    }

    public function setSelected($selected)
    {
        $this->selected = $selected;
    }
}
