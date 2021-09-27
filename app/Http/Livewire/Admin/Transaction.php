<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActivePlan;
use App\Models\ConfirmPayment;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Transaction extends Component
{
    use WithFileUploads;
    public $tbl_transactions_id;
    public $confirm_payment_id;
    public $confirm_bank_name;
    public $confirm_bank_account_name;
    public $confirm_bank_account_number;
    public $confirm_amount;
    public $confirm_date;
    public $confirm_photo;
    public $confirm_photo_path;
    public $transaction_note;
    public $transaction_status;
    public $transaction;
    public $status;
    public $bank_id;
    public $plan_id;
    public $user_id;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-transactions', [
            'items' => ModelsTransaction::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $confirm_payment = ConfirmPayment::find($this->confirm_payment_id);
            $confirm_payment->update([
                'confirm_note' => $this->transaction_note,
                'confirm_status' => $this->transaction_status
            ]);
            $confirm_payment->transaction()->update([
                'transaction_note' => $this->transaction_note,
                'transaction_status' => $this->transaction_status
            ]);
            if ($this->transaction_status == 2) {
                $date = date('Y-m-d H:i:s');
                $duration = $confirm_payment->transaction->plan->plan_duration;
                ActivePlan::create([
                    'plan_start_date'  => $date,
                    'plan_end_date'  => date('Y-m-d H:i:s', strtotime("+$duration days", strtotime($date))),
                    'plan_status'  => 0,
                    'plan_id'  => $confirm_payment->transaction->plan->id,
                    'user_id'  => $confirm_payment->transaction->user_id
                ]);
            }

            $this->_reset();
            DB::commit();
            return $this->emit('showAlert', ['msg' => 'Pembayaran Berhasil Dikonfirmasi']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Pembayaran Gagal Dikonfirmasi']);
        }
    }

    public function confirmPayment()
    {
        $this->validate([
            'confirm_bank_name' => 'required',
            'confirm_bank_account_name' => 'required',
            'confirm_bank_account_number' => 'required|numeric',
            'confirm_amount' => 'required',
            'confirm_photo_path' => 'required|image',
            'confirm_date' => 'required',
        ]);
        $confirm_photo = $this->confirm_photo_path->store('upload', 'public');
        try {
            DB::beginTransaction();
            $transaction = ModelsTransaction::find($this->transaction->id);
            ConfirmPayment::create([
                'confirm_bank_name' => $this->confirm_bank_name,
                'confirm_bank_account_name' => $this->confirm_bank_account_name,
                'confirm_bank_account_number' => $this->confirm_bank_account_number,
                'confirm_amount' => $this->confirm_amount,
                'confirm_photo' => $confirm_photo,
                'confirm_date' => $this->confirm_date,
                'confirm_status' => 1,
                'transaction_id' => $transaction->id,
                'user_id' => auth()->user()->id,
            ]);

            $transaction->update(['transaction_status' => 1]);

            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Pembayaran Berhasil dikonfirmasi', 'redirect' => true, 'path' => '/']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Terjadi Kesalahan']);
        }
    }

    public function _validate()
    {
        $rule = [
            'transaction_status'  => 'required',
        ];
        if ($this->transaction_status == 3) {
            $rule['transaction_note'] = 'required';
        }


        return $this->validate($rule);
    }

    public function getId($tbl_transactions_id)
    {
        $user = auth()->user();
        $tbl_transactions = ModelsTransaction::find($tbl_transactions_id);
        $confirm_payment = $tbl_transactions->confirmPayment()->orderBy('created_at', 'DESC')->first();
        if (in_array($user->role->role_type, ['admin', 'superadmin'])) {
            $this->confirm_payment_id = $confirm_payment->id;
            $this->confirm_bank_name = $confirm_payment->confirm_bank_name;
            $this->confirm_bank_account_name = $confirm_payment->confirm_bank_account_name;
            $this->confirm_bank_account_number = $confirm_payment->confirm_bank_account_number;
            $this->confirm_amount = $confirm_payment->confirm_amount;
            $this->confirm_date = $confirm_payment->confirm_date;
            $this->confirm_photo = $confirm_payment->confirm_photo;
        }
        $this->status = $confirm_payment->confirm_status;
        $this->transaction = $tbl_transactions;
        $this->showModal();
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->confirm_payment_id = null;
        $this->confirm_bank_name = null;
        $this->confirm_bank_account_name = null;
        $this->confirm_bank_account_number = null;
        $this->confirm_amount = null;
        $this->confirm_date = null;
        $this->confirm_photo = null;
        $this->status = null;
        $this->transaction = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
