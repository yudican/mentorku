<?php

namespace App\Http\Livewire\Client;

use App\Models\Bank;
use App\Models\ConfirmPayment;
use App\Models\Plan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Subscription extends Component
{
    use WithFileUploads;
    public $plan_id;
    public $plans;
    public $formType = 1;
    public $bank_id;
    public $transaction;

    // confirm payment
    public $confirm_bank_name;
    public $confirm_bank_account_name;
    public $confirm_bank_account_number;
    public $confirm_amount;
    public $confirm_photo;
    public $confirm_photo_path;
    public $confirm_date;

    public function mount($plan_id)
    {
        $plans = Plan::find($plan_id);
        if (!$plans) {
            return abort(404);
        }

        $this->plan_id = $plan_id;
        $this->plans = $plans;
    }


    public function render()
    {
        return view('livewire.client.subscription', [
            'banks' => Bank::all()
        ])->layout('layouts.user');
    }

    public function typeForm($form = 1)
    {
        if ($form == 3) {
            if (!$this->bank_id) {
                return $this->formType = 2;
            }
            $unique_code =  rand(123, 999);
            $total_price =  $this->plans->plan_price + $unique_code;
            $transaction_date = date('Y-m-d H:i:s');
            $this->transaction = Transaction::create([
                'transaction_total_price' => $total_price,
                'transaction_unique_id' => substr($total_price, -3),
                'transaction_date' => $transaction_date,
                'transaction_expired_date' => date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_date))),
                'bank_id' => $this->bank_id,
                'plan_id' => $this->plan_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->formType = $form;
            return $this->emit('showAlert', ['msg' => 'Transaksi Berhasil Dibuat']);
        }
        $this->formType = $form;
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
            $transaction = Transaction::find($this->transaction->id);
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

            return $this->emit('showAlert', ['msg' => 'Pembayaran Berhasil dikonfirmasi', 'redirect' => true, 'path' => '/']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Terjadi Kesalahan']);
        }
    }

    public function selectBank($bank_id)
    {
        $this->bank_id = $bank_id;
    }
}
