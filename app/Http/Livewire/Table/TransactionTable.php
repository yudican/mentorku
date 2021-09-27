<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Transaction;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class TransactionTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_transactions';
    public $hide = [];


    public function builder()
    {
        $user = auth()->user();
        if ($user->role->role_type == 'member') {
            return Transaction::query()->orderBy('transaction_date', 'desc')->where('user_id', $user->id);
        }
        return Transaction::query()->orderBy('transaction_date', 'desc');
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        $user = auth()->user();
        $data = [
            Column::callback('transaction_total_price', function ($transaction_total_price) {
                return 'Rp. ' . number_format($transaction_total_price);
            })->label('Total Price')->width(200),
            Column::name('transaction_unique_id')->label('Payment Unique'),
            Column::name('transaction_date')->label('Transaction Date')->width(350),
            Column::name('transaction_expired_date')->label('Due Date')->width(350),
            Column::name('transaction_note')->label('Note')->width(350),
            Column::callback('transaction_status', function ($transaction_status) {
                switch ($transaction_status) {
                    case 0:
                        return '<button type="button"class="btn btn-info btn-sm">Waiting Payment</button>';
                    case 1:
                        return '<button type="button"class="btn btn-warning btn-sm">On Progress</button>';
                    case 2:
                        return '<button type="button"class="btn btn-success btn-sm">Success</button>';
                    case 3:
                        return '<button type="button"class="btn btn-danger btn-sm">Decline</button>';
                    default:
                        return '<button type="button"class="btn btn-danger btn-sm">Expired</button>';
                }
            })->label('Status'),
            Column::callback(['bank.bank_logo'], function ($image) {
                return view('livewire.components.photo', [
                    'image_url' => asset('storage/' . $image),
                ]);
            })->label(__('Payment Type')),
            Column::name('plan.plan_title')->label('Plan Name')->searchable()->width(200),
        ];

        if (in_array($user->role->role_type, ['admin', 'superadmin'])) {
            $data[7] = Column::name('user.name')->label('User')->searchable()->width(300);
        }

        $data[8] = Column::callback(['tbl_transactions.id', 'tbl_transactions.transaction_status'], function ($id, $status) {
            return view('livewire.components.confirm-button', [
                'id' => $id,
                'status' => $status,
                'segment' => request()->segment(1)
            ]);
        })->label(__('Aksi'));

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
