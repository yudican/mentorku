<?php

namespace App\Http\Livewire\Master;

use App\Models\Plan as ModelsPlan;
use Livewire\Component;


class Plan extends Component
{

    public $tbl_plans_id;
    public $plan_title;
    public $plan_price;
    public $plan_duration;
    public $plan_max_mentor;
    public $plan_max_type;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-plans', [
            'items' => ModelsPlan::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'plan_title'  => $this->plan_title,
            'plan_price'  => $this->plan_price,
            'plan_duration'  => $this->plan_duration,
            'plan_max_mentor'  => $this->plan_max_mentor,
            'plan_max_type'  => $this->plan_max_type
        ];

        ModelsPlan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'plan_title'  => $this->plan_title,
            'plan_price'  => $this->plan_price,
            'plan_duration'  => $this->plan_duration,
            'plan_max_mentor'  => $this->plan_max_mentor,
            'plan_max_type'  => $this->plan_max_type
        ];
        $row = ModelsPlan::find($this->tbl_plans_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsPlan::find($this->tbl_plans_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'plan_title'  => 'required',
            'plan_price'  => 'required',
            'plan_duration'  => 'required',
            'plan_max_mentor'  => 'required',
            'plan_max_type'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_plans_id)
    {
        $tbl_plans = ModelsPlan::find($tbl_plans_id);
        $this->tbl_plans_id = $tbl_plans->id;
        $this->plan_title = $tbl_plans->plan_title;
        $this->plan_price = $tbl_plans->plan_price;
        $this->plan_duration = $tbl_plans->plan_duration;
        $this->plan_max_mentor = $tbl_plans->plan_max_mentor;
        $this->plan_max_type = $tbl_plans->plan_max_type;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_plans_id)
    {
        $tbl_plans = ModelsPlan::find($tbl_plans_id);
        $this->tbl_plans_id = $tbl_plans->id;
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
        $this->tbl_plans_id = null;
        $this->plan_title = null;
        $this->plan_price = null;
        $this->plan_duration = null;
        $this->plan_max_mentor = null;
        $this->plan_max_type = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
