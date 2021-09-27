<?php

namespace App\Http\Livewire\Client;

use App\Models\Category;
use App\Models\Mentor;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class MentorProfile extends Component
{
    use WithFileUploads;
    public $mentors_id;
    public $mentor_name;
    public $mentor_email;
    public $phone_number;
    public $mentor_keahlian;
    public $mentor_exp;
    public $mentor_description;
    public $mentor_intruduction_url_vidio;
    public $category_id;
    public $subcategory_id;
    public $sub_categories = [];
    public $user_photo;
    public $user_photo_path;

    public function mount()
    {
        $user = auth()->user();
        $this->mentors_id = $user->mentor->id;
        $this->mentor_keahlian = $user->mentor->mentor_keahlian;
        $this->mentor_exp = $user->mentor->mentor_exp;
        $this->mentor_description = $user->mentor->mentor_description;
        $this->mentor_intruduction_url_vidio = $user->mentor->mentor_intruduction_url_vidio;
        $this->category_id = $user->mentor->category_id;
        $this->mentor_name = $user->name;
        $this->mentor_email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->user_photo = $user->profile_photo_path;

        $this->getSubCategory($user->mentor->category_id);
        $this->subcategory_id = $user->mentor->subcategory_id;
    }
    public function render()
    {
        return view('livewire.client.mentor-profile', [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ]);
    }

    public function updateProfile()
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

            $data_user = [
                'name' => $this->mentor_name,
                'email' => $this->mentor_email,
                'phone_number' => $this->phone_number,
            ];
            if ($this->user_photo_path) {
                $user_photo = $this->user_photo_path->store('upload', 'public');
                $data_user['profile_photo_path'] = $user_photo;
                if (Storage::exists('public/' . $this->user_photo)) {
                    Storage::delete('public/' . $this->user_photo);
                }
            }

            $row = Mentor::find($this->mentors_id);
            $row->user()->update($data_user);
            $row->update($data);
            DB::commit();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
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
            'phone_number'  => 'required|numeric',
        ];

        return $this->validate($rule);
    }

    public function getSubCategory($category_id)
    {
        $this->subcategory_id = '';
        $this->sub_categories = SubCategory::where('category_id', $category_id)->get();
    }
}
