<?php

namespace App\Http\Livewire\Master;

use App\Models\Category;
use App\Models\SubCategory as ModelsSubCategory;
use Livewire\Component;


class SubCategory extends Component
{

    public $tbl_sub_categories_id;
    public $subcategory_name;
    public $category_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-sub-categories', [
            'items' => ModelsSubCategory::all(),
            'categories' => Category::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'subcategory_name'  => $this->subcategory_name,
            'category_id'  => $this->category_id
        ];

        ModelsSubCategory::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'subcategory_name'  => $this->subcategory_name,
            'category_id'  => $this->category_id
        ];
        $row = ModelsSubCategory::find($this->tbl_sub_categories_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSubCategory::find($this->tbl_sub_categories_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'subcategory_name'  => 'required',
            'category_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_sub_categories_id)
    {
        $tbl_sub_categories = ModelsSubCategory::find($tbl_sub_categories_id);
        $this->tbl_sub_categories_id = $tbl_sub_categories->id;
        $this->subcategory_name = $tbl_sub_categories->subcategory_name;
        $this->category_id = $tbl_sub_categories->category_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_sub_categories_id)
    {
        $tbl_sub_categories = ModelsSubCategory::find($tbl_sub_categories_id);
        $this->tbl_sub_categories_id = $tbl_sub_categories->id;
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
        $this->tbl_sub_categories_id = null;
        $this->subcategory_name = null;
        $this->category_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
