<?php

namespace App\Http\Livewire\Admin;

use App\Models\Schedule as ModelsSchedule;
use Livewire\Component;


class Schedule extends Component
{

    public $tbl_schedules_id;
    public $schedule_topic;
    public $schedule_date;
    public $schedule_duration;
    public $schedule_link_meet;
    public $schedule_note;
    public $schedule_status;
    public $mentor_id;
    public $user_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-schedules', [
            'items' => ModelsSchedule::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'schedule_topic'  => $this->schedule_topic,
            'schedule_date'  => $this->schedule_date,
            'schedule_duration'  => $this->schedule_duration,
            'schedule_link_meet'  => $this->schedule_link_meet,
            'schedule_note'  => $this->schedule_note,
            'schedule_status'  => $this->schedule_status,
            'mentor_id'  => $this->mentor_id,
            'user_id'  => $this->user_id
        ];

        ModelsSchedule::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'schedule_link_meet'  => $this->schedule_link_meet,
            'schedule_note'  => $this->schedule_note,
            'schedule_status'  => $this->schedule_status,
        ];
        $row = ModelsSchedule::find($this->tbl_schedules_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSchedule::find($this->tbl_schedules_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'schedule_status'  => 'required',
        ];

        if ($this->schedule_status == 1) {
            $rule['schedule_link_meet'] = 'required';
        }

        if ($this->schedule_status == 2) {
            $rule['schedule_note'] = 'required';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_schedules_id)
    {
        $tbl_schedules = ModelsSchedule::find($tbl_schedules_id);
        $this->tbl_schedules_id = $tbl_schedules->id;
        $this->schedule_topic = $tbl_schedules->schedule_topic;
        $this->schedule_date = $tbl_schedules->schedule_date;
        $this->schedule_duration = $tbl_schedules->schedule_duration;
        $this->schedule_link_meet = $tbl_schedules->schedule_link_meet;
        $this->schedule_note = $tbl_schedules->schedule_note;
        $this->schedule_status = $tbl_schedules->schedule_status;
        $this->mentor_id = $tbl_schedules->mentor_id;
        $this->user_id = $tbl_schedules->user_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_schedules_id)
    {
        $tbl_schedules = ModelsSchedule::find($tbl_schedules_id);
        $this->tbl_schedules_id = $tbl_schedules->id;
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
        $this->tbl_schedules_id = null;
        $this->schedule_topic = null;
        $this->schedule_date = null;
        $this->schedule_duration = null;
        $this->schedule_link_meet = null;
        $this->schedule_note = null;
        $this->schedule_status = null;
        $this->mentor_id = null;
        $this->user_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
