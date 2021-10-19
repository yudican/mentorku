<?php

namespace App\Http\Livewire\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileUser extends Component
{
    use WithFileUploads;
    public $user_id;
    public $user_name;
    public $user_email;
    public $phone_number;
    public $user_photo;
    public $user_photo_path;

    public $current_password;
    public $new_password;
    public $confirm_new_password;

    public function mount()
    {
        $user = auth()->user();
        $this->user_id = $user->id;
        $this->user_name = $user->name;
        $this->user_email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->user_photo = $user->profile_photo_path;
    }

    public function render()
    {
        return view('livewire.client.profile-user');
    }

    public function updateProfile()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $user = auth()->user();
            $data_user = [
                'name' => $this->user_name,
                'email' => $this->user_email,
                'phone_number' => $this->phone_number,
            ];
            if ($this->user_photo_path) {
                $user_photo = $this->user_photo_path->store('upload', 'public');
                $data_user['profile_photo_path'] = $user_photo;
                if (Storage::exists('public/' . $this->user_photo)) {
                    Storage::delete('public/' . $this->user_photo);
                }
            }

            $user->update($data_user);
            DB::commit();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
        }
    }

    public function updatePassword()
    {
        $this->_validatePassword();

        $user = User::find($this->user_id);
        if ($user) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->_reset();
                return $this->emit('showAlertError', ['msg' => 'Password Lama Salah']);
            }

            $user->update([
                'password' => Hash::make($this->new_password)
            ]);

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Password Berhasil Diupdate']);
        }
    }

    public function _validate()
    {
        $rule = [
            'user_name'  => 'required',
            'user_email'  => 'required|email',
            'phone_number'  => 'required|numeric',
        ];

        return $this->validate($rule);
    }

    public function _validatePassword()
    {
        $rule = [
            'current_password'  => 'required',
            'new_password'  => 'required|min:8',
            'confirm_new_password'  => 'required|same:new_password',
        ];

        return $this->validate($rule);
    }

    public function _reset()
    {
        $this->current_password = null;
        $this->new_password = null;
        $this->confirm_new_password = null;
    }
}
