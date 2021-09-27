<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <x-text-field type="text" name="mentor_name" label="Nama Mentor" />
                            <x-text-field type="text" name="mentor_email" label="Email Mentor" />
                            <x-text-field type="text" name="phone_number" label="Phone Number" />
                            <x-select name="category_id" label="kategori" handleChange="getSubCategory">
                                <option value="">Select kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="col-md-6">
                            <x-select name="subcategory_id" label="Sub kategori">
                                <option value="">Select Sub kategori</option>
                                @foreach ($sub_categories as $sub_category)
                                <option value="{{$sub_category->id}}">{{$sub_category->subcategory_name}}</option>
                                @endforeach
                            </x-select>
                            <x-text-field type="text" name="mentor_keahlian" label="Keahlian" />
                            <x-text-field type="number" name="mentor_exp" label="Pengalaman" />
                            <x-text-field type="text" name="mentor_intruduction_url_vidio"
                                label="Url Vidio Perkenalan" />
                        </div>
                    </div>


                    <x-textarea type="textarea" name="mentor_description" label="Deskripsi" />

                    <x-input-photo foto="{{$user_photo}}" path="{{optional($user_photo_path)->temporaryUrl()}}"
                        name="user_photo_path" label="Profile" />

                    <div class="form-group">
                        <button type="button" wire:click="updateProfile" class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>