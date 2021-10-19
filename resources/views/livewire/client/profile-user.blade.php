<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-text-field type="text" name="user_name" label="Nama" />
                    <x-text-field type="text" name="user_email" label="Email" />
                    <x-text-field type="text" name="phone_number" label="Phone Number" />

                    <x-input-photo foto="{{$user_photo}}" path="{{optional($user_photo_path)->temporaryUrl()}}"
                        name="user_photo_path" label="Profile" />

                    <div class="form-group">
                        <button type="button" wire:click="updateProfile" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-text-field type="password" name="current_password" label="Password Sekarang" />
                    <x-text-field type="password" name="new_password" label="Password Baru" />
                    <x-text-field type="password" name="confirm_new_password" label="Konfirmasi Password" />

                    <div class="form-group">
                        <button type="button" wire:click="updatePassword" class="btn btn-danger btn-sm">Update</button>
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