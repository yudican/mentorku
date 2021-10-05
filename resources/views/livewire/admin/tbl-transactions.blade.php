<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Transaction List</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.transaction-table />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">
                            Confirm Payment</h5>
                    </div>
                    <div class="modal-body">
                        @if (Auth::user()->role->role_type == 'member')
                        <x-text-field type="text" name="confirm_bank_name" label="Bank Name" />
                        <x-text-field type="text" name="confirm_bank_account_name" label="Bank Account Name" />
                        <x-text-field type="text" name="confirm_bank_account_number" label="Bank Account Number" />
                        <x-text-field type="number" name="confirm_amount" label="Amount" />
                        <x-text-field type="date" name="confirm_date" label="Payment Date" />
                        <x-input-photo foto="{{$confirm_photo}}"
                            path="{{optional($confirm_photo_path)->temporaryUrl()}}" name="confirm_photo_path"
                            label="Upload Photo" />

                        @else
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nama Bank
                            <span>{{$confirm_bank_name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nama Akun Bank
                            <span>{{$confirm_bank_account_name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nomor Rekening
                            <span>{{$confirm_bank_account_number}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Jumlah Bayar
                            <span>Rp. {{number_format($confirm_amount)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Tanggal bayar
                            <span>{{$confirm_date}}</span>
                        </li>
                        <li class="list-group-item border-0 text-center justify-content-center align-items-center">
                            <img src="{{asset('storage/'.$confirm_photo)}}" style="height: 200px;" alt="">
                        </li>

                        <x-select name="transaction_status" label="Status">
                            <option value="">Select Status</option>
                            <option value="2">Approve</option>
                            <option value="3">Decline</option>
                        </x-select>
                        @if ($transaction_status == 3)
                        <x-textarea name="transaction_note" label="Catatan" />
                        @endif
                        @endif



                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->role->role_type == 'member')
                        <button type="button" wire:click='confirmPayment' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Simpan</button>
                        @else
                        @if ($status == 1)
                        <button type="button" wire:click='store' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Simpan</button>
                        @endif
                        @endif


                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>

                    </div>
                </div>
            </div>
        </div>


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>
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