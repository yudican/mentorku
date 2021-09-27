<?php

namespace App\Http\Livewire\Master;

use App\Models\Category as ModelsCategory;
use Livewire\Component;


class Category extends Component
{
    
    public $tbl_categories_id;
    public $category_name;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-categories', [
            'items' => ModelsCategory::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['category_name'  => $this->category_name];

        ModelsCategory::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['category_name'  => $this->category_name];
        $row = ModelsCategory::find($this->tbl_categories_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsCategory::find($this->tbl_categories_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'category_name'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_categories_id)
    {
        $tbl_categories = ModelsCategory::find($tbl_categories_id);
        $this->tbl_categories_id = $tbl_categories->id;
        $this->category_name = $tbl_categories->category_name;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_categories_id)
    {
        $tbl_categories = ModelsCategory::find($tbl_categories_id);
        $this->tbl_categories_id = $tbl_categories->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_categories_id = null;
        $this->category_name = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
