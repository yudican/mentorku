<?php

namespace App\Http\Livewire\Master;

use App\Models\Bank as ModelsBank;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Bank extends Component
{
    use WithFileUploads;
    public $tbl_banks_id;
    public $bank_name;
    public $bank_acount_name;
    public $bank_acount_number;
    public $bank_logo;
    public $bank_logo_path;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-banks', [
            'items' => ModelsBank::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $bank_logo = $this->bank_logo_path->store('upload', 'public');
        $data = [
            'bank_name'  => $this->bank_name,
            'bank_acount_name'  => $this->bank_acount_name,
            'bank_acount_number'  => $this->bank_acount_number,
            'bank_logo'  => $bank_logo
        ];

        ModelsBank::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();
        $data = [
            'bank_name'  => $this->bank_name,
            'bank_acount_name'  => $this->bank_acount_name,
            'bank_acount_number'  => $this->bank_acount_number,
        ];
        if ($this->bank_logo_path) {
            $bank_logo = $this->bank_logo_path->store('upload', 'public');
            $data = ['bank_logo' => $bank_logo];
            if (Storage::exists('public/' . $this->bank_logo)) {
                Storage::delete('public/' . $this->bank_logo);
            }
        }
        $row = ModelsBank::find($this->tbl_banks_id);

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsBank::find($this->tbl_banks_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'bank_name'  => 'required',
            'bank_acount_name'  => 'required',
            'bank_acount_number'  => 'required',
            'bank_logo_path'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_banks_id)
    {
        $tbl_banks = ModelsBank::find($tbl_banks_id);
        $this->tbl_banks_id = $tbl_banks->id;
        $this->bank_name = $tbl_banks->bank_name;
        $this->bank_acount_name = $tbl_banks->bank_acount_name;
        $this->bank_acount_number = $tbl_banks->bank_acount_number;
        $this->bank_logo = $tbl_banks->bank_logo;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_banks_id)
    {
        $tbl_banks = ModelsBank::find($tbl_banks_id);
        $this->tbl_banks_id = $tbl_banks->id;
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
        $this->tbl_banks_id = null;
        $this->bank_name = null;
        $this->bank_acount_name = null;
        $this->bank_acount_number = null;
        $this->bank_logo = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
