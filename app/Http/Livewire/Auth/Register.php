<?php

namespace App\Http\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $bod;
    public $phone_number;
    public $password;
    public $password_confirmation;


    public function render()
    {
        return view('livewire.auth.register');
    }

    public function store()
    {
        // dd('ok');
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'bod' => 'required',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ];

        $this->validate($rules);
        try {
            DB::beginTransaction();
            $role_mentor = Role::where('role_type', 'member')->first();
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'bod' => $this->bod,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
                'current_team_id' => 1
            ]);

            $user->roles()->attach($role_mentor->id);
            $user->teams()->attach(1, ['role' => $role_mentor->role_type]);

            DB::commit();
            $this->_resetForm();
            return $this->emit('showAlert', [
                'msg' => 'Registrasi Berhasil, silahkan login.',
                'redirect' => true,
                'path' => 'login'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', [
                'msg' => 'Registrasi Gagal.',
                'redirect' => true,
                'path' => 'login'
            ]);
        }
    }

    public function _resetForm()
    {
        $this->name = null;
        $this->email = null;
        $this->bod = null;
        $this->phone_number = null;
        $this->password = null;
        $this->password_confirmation = null;
    }
}
