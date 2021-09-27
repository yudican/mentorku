<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Schedule;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;
use App\Models\Mentor;

class ScheduleTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_schedules';
    public $hide = [];


    public function builder()
    {
        $user = auth()->user();
        if (in_array($user->role->role_type, ['member'])) {
            return Schedule::query()->where('schedules.user_id', $user->id);
        }
        if (in_array($user->role->role_type, ['mentor'])) {
            return Schedule::query()->where('schedules.mentor_id', $user->mentor->id);
        }
        return Schedule::query();
    }

    public function columns()
    {
        $user = auth()->user();
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        $data = [
            Column::name('schedule_topic')->label('Topik')->searchable(),
            Column::name('schedule_date')->label('Schedule date'),
            Column::callback('schedule_duration', function ($duration) {
                return $duration . ' Hour';
            })->label('Duration'),
            Column::callback('schedule_link_meet', function ($link) {
                return "<a href='$link'>$link</a>";
            })->label('Link meet'),
            Column::name('schedule_note')->label('Note'),
            Column::callback('schedule_status', function ($schedule_status) {
                switch ($schedule_status) {
                    case 0:
                        return '<button type="button"class="btn btn-warning btn-sm">Waiting Approval</button>';
                    case 1:
                        return '<button type="button"class="btn btn-success btn-sm">Approve</button>';
                    case 2:
                        return '<button type="button"class="btn btn-danger btn-sm">Decline</button>';
                    case 3:
                        return '<button type="button"class="btn btn-danger btn-sm">Canceled</button>';
                }
            })->label('Status'),
        ];

        if (in_array($user->role->role_type, ['mentor'])) {
            $data[6] = Column::name('user.name')->label('User')->searchable();
            $data[7] = Column::callback(['id'], function ($id) {
                return view('livewire.components.mentor-action', [
                    'id' => $id,
                    'segment' => request()->segment(1)
                ]);
            })->label(__('Aksi'));
        } else if (in_array($user->role->role_type, ['member'])) {
            $data[7] = Column::callback('mentor_id', function ($mentor_id) {
                $mentor = Mentor::find($mentor_id);
                return $mentor->user->name;
            })->label('Mentor')->searchable();
        } else {
            $data[6] = Column::name('user.name')->label('User')->searchable();
            $data[7] = Column::callback('mentor_id', function ($mentor_id) {
                $mentor = Mentor::find($mentor_id);
                return $mentor->user->name;
            })->label('Mentor')->searchable();
        }

        return $data;
    }

    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
