<?php

namespace App\Http\Livewire\Client;

use App\Models\ActivePlan as ModelsActivePlan;
use Livewire\Component;


class ActivePlan extends Component
{

    public $tbl_active_plans_id;
    public $plan_start_date;
    public $plan_end_date;
    public $plan_status;
    public $plan_id;
    public $user_id;



    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.client.tbl-active-plans', [
            'items' => ModelsActivePlan::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'plan_start_date'  => $this->plan_start_date,
            'plan_end_date'  => $this->plan_end_date,
            'plan_status'  => $this->plan_status,
            'plan_id'  => $this->plan_id,
            'user_id'  => $this->user_id
        ];

        ModelsActivePlan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'plan_start_date'  => $this->plan_start_date,
            'plan_end_date'  => $this->plan_end_date,
            'plan_status'  => $this->plan_status,
            'plan_id'  => $this->plan_id,
            'user_id'  => $this->user_id
        ];
        $row = ModelsActivePlan::find($this->tbl_active_plans_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsActivePlan::find($this->tbl_active_plans_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'plan_start_date'  => 'required',
            'plan_end_date'  => 'required',
            'plan_status'  => 'required',
            'plan_id'  => 'required',
            'user_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_active_plans_id)
    {
        $tbl_active_plans = ModelsActivePlan::find($tbl_active_plans_id);
        $this->tbl_active_plans_id = $tbl_active_plans->id;
        $this->plan_start_date = $tbl_active_plans->plan_start_date;
        $this->plan_end_date = $tbl_active_plans->plan_end_date;
        $this->plan_status = $tbl_active_plans->plan_status;
        $this->plan_id = $tbl_active_plans->plan_id;
        $this->user_id = $tbl_active_plans->user_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_active_plans_id)
    {
        $tbl_active_plans = ModelsActivePlan::find($tbl_active_plans_id);
        $this->tbl_active_plans_id = $tbl_active_plans->id;
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
        $this->tbl_active_plans_id = null;
        $this->plan_start_date = null;
        $this->plan_end_date = null;
        $this->plan_status = null;
        $this->plan_id = null;
        $this->user_id = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
