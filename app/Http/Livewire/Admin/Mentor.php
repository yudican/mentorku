<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Mentor as ModelsMentor;
use App\Models\Role;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class Mentor extends Component
{

    public $tbl_mentors_id;
    public $mentor_name;
    public $mentor_email;
    public $mentor_keahlian;
    public $mentor_exp;
    public $mentor_description;
    public $mentor_intruduction_url_vidio;
    public $category_id;
    public $subcategory_id;
    public $sub_categories = [];



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {

        return view('livewire.admin.tbl-mentors', [
            'items' => ModelsMentor::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $role_mentor = Role::where('role_type', 'mentor')->first();
            $user = User::create([
                'name' => $this->mentor_name,
                'email' => $this->mentor_email,
                'password' => Hash::make('mentor123'),
                'current_team_id' => 1,
            ]);
            $data = [
                'mentor_keahlian'  => $this->mentor_keahlian,
                'mentor_exp'  => $this->mentor_exp,
                'mentor_description'  => $this->mentor_description,
                'mentor_intruduction_url_vidio'  => $this->mentor_intruduction_url_vidio,
                'category_id'  => $this->category_id,
                'subcategory_id'  => $this->subcategory_id,
                'user_id' => $user->id
            ];

            $user->roles()->attach($role_mentor->id);
            $user->teams()->attach(1, ['role' => $role_mentor->role_type]);
            ModelsMentor::create($data);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan']);
        }
    }

    public function update()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $data = [
                'mentor_keahlian'  => $this->mentor_keahlian,
                'mentor_exp'  => $this->mentor_exp,
                'mentor_description'  => $this->mentor_description,
                'mentor_intruduction_url_vidio'  => $this->mentor_intruduction_url_vidio,
                'category_id'  => $this->category_id,
                'subcategory_id'  => $this->subcategory_id,
            ];

            $row = ModelsMentor::find($this->tbl_mentors_id);
            $row->user()->update([
                'name' => $this->mentor_name,
                'email' => $this->mentor_email,
            ]);
            $row->update($data);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
        }
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
            $mentor = ModelsMentor::find($this->tbl_mentors_id);
            $mentor->user->roles()->detach();
            $mentor->user->teams()->detach();
            $mentor->user->delete();
            $mentor->delete();

            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil dihapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal dihapus']);
        }
    }

    public function _validate()
    {
        $rule = [
            'mentor_keahlian'  => 'required',
            'mentor_exp'  => 'required|numeric',
            'mentor_description'  => 'required',
            'mentor_intruduction_url_vidio'  => 'required',
            'category_id'  => 'required|numeric',
            'subcategory_id'  => 'required|numeric',
            'mentor_name'  => 'required',
            'mentor_email'  => 'required|email',
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_mentors_id)
    {
        $tbl_mentors = ModelsMentor::find($tbl_mentors_id);
        $this->tbl_mentors_id = $tbl_mentors->id;
        $this->mentor_keahlian = $tbl_mentors->mentor_keahlian;
        $this->mentor_exp = $tbl_mentors->mentor_exp;
        $this->mentor_description = $tbl_mentors->mentor_description;
        $this->mentor_intruduction_url_vidio = $tbl_mentors->mentor_intruduction_url_vidio;
        $this->category_id = $tbl_mentors->category_id;
        $this->subcategory_id = $tbl_mentors->subcategory_id;
        $this->mentor_name = $tbl_mentors->user->name;
        $this->mentor_email = $tbl_mentors->user->email;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_mentors_id)
    {
        $tbl_mentors = ModelsMentor::find($tbl_mentors_id);
        $this->tbl_mentors_id = $tbl_mentors->id;
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
        $this->tbl_mentors_id = null;
        $this->mentor_keahlian = null;
        $this->mentor_name = null;
        $this->mentor_email = null;
        $this->mentor_exp = null;
        $this->mentor_description = null;
        $this->mentor_intruduction_url_vidio = null;
        $this->category_id = null;
        $this->subcategory_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }

    public function getSubCategory($category_id)
    {
        $this->subcategory_id = '';
        $this->sub_categories = SubCategory::where('category_id', $category_id)->get();
    }
}
