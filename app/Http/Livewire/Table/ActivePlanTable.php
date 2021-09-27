<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\ActivePlan;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class ActivePlanTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_active_plans';
    public $hide = [];


    public function builder()
    {
        $user = auth()->user();
        if ($user->role->role_type == 'member') {
            return ActivePlan::query()->where('user_id', $user->id);
        }
        return ActivePlan::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        $user = auth()->user();
        $data = [
            Column::name('plan_start_date')->label('Start date'),
            Column::name('plan_end_date')->label('End Date'),
            Column::callback('plan_status', function ($plan_status) {
                switch ($plan_status) {
                    case 0:
                        return '<button type="button"class="btn btn-success btn-sm">ACTIVE</button>';
                    case 2:
                        return '<button type="button"class="btn btn-warning btn-sm">SUSPEND</button>';
                    case 3:
                        return '<button type="button"class="btn btn-DANGER btn-sm">INACTIVE</button>';
                }
            })->label('Status'),
            Column::name('plan.plan_title')->label('Plan')->searchable(),
        ];

        if (in_array($user->role->role_type, ['admin', 'superadmin'])) {
            $data[4] = Column::name('user.name')->label('User')->searchable();
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
