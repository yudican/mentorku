<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('home-user')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Berlangganan</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                @if ($formType == 1)
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item border-0">
                            <span><strong>Rincian Pembelian</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nama Package
                            <span>{{$plans->plan_title}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Harga Package
                            <span>Rp. {{number_format($plans->plan_price)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Durasi Package
                            <span>{{$plans->plan_duration}}/Hari</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Jumlah Mentor/{{$plans->plan_max_type}}
                            <span>{{$plans->plan_max_mentor}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <strong>Total Bayar</strong>
                            <span><strong>Rp. {{number_format($plans->plan_price)}}</strong></span>
                        </li>
                    </ul>
                </div>
                @elseif ($formType == 2)
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item border-0">
                            <span><strong>Metode Pembayaran</strong></span>
                        </li>
                        @foreach ($banks as $bank)
                        <div wire:click="selectBank({{$bank->id}})"
                            class="list-group-item d-flex justify-content-between align-items-center mx-3 mt-2 cursor-pointer"
                            style="border: 1px solid {{$bank->id == $bank_id ? '#2980b9' : '#e4e4e4'}};border-radius:5px;">
                            <img src="{{asset('storage/'.$bank->bank_logo)}}" alt="{{$bank->bank_name}}" height="30">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        @endforeach
                    </ul>
                </div>
                @elseif ($formType == 3)
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item border-0">
                            <span><strong>Detail Pembayaran</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nama Bank
                            <span>{{$transaction->bank->bank_name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nama Akun Bank
                            <span>{{$transaction->bank->bank_acount_name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Nomor Rekening
                            <span>{{$transaction->bank->bank_acount_number}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            Kode Unik
                            <span>{{$transaction->transaction_unique_id}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <span>
                                Kami akan memproses transfer Anda lebih cepat jika Anda melakukan pembayaran dengan
                                jumlah
                                yang
                                tiga digit terakhirnya <strong>[{{$transaction->transaction_unique_id}}]</strong>.
                                <br>
                                <strong>Contoh: Rp. {{$transaction->transaction_total_price}}</strong>. <br>
                                Agar pembayaran Anda terlihat unik, digitnya diambil dari random angka. Dengan
                                begitu
                                waktu yang dibutuhkan untuk melacak dan memproses transfer semacam ini di antara
                                banyaknya
                                permintaan akan lebih sedikit
                            </span>
                        </li>

                    </ul>
                </div>
                @elseif ($formType == 4)
                <div class="card-body">
                    <x-text-field type="text" name="confirm_bank_name" label="Bank Name" />
                    <x-text-field type="text" name="confirm_bank_account_name" label="Bank Account Name" />
                    <x-text-field type="text" name="confirm_bank_account_number" label="Bank Account Number" />
                    <x-text-field type="number" name="confirm_amount" label="Amount" />
                    <x-text-field type="date" name="confirm_date" label="Payment Date" />
                    <x-input-photo foto="{{$confirm_photo}}" path="{{optional($confirm_photo_path)->temporaryUrl()}}"
                        name="confirm_photo_path" label="Upload Photo" />

                    <div class="form-group">
                        <button type="button" wire:click="confirmPayment" class="btn btn-danger btn-sm">Simpan</button>
                    </div>
                </div>
                @endif
            </div>
            @if ($formType < 4) <div class="card  cursor-pointer">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a wire:click="typeForm({{$formType+1}})"
                            class="d-flex justify-content-between align-items-center">
                            @if ($formType == 1)
                            <span class="ml-3">Lanjutkan</span>
                            @elseif ($formType == 2)
                            <span class="ml-3">Buat Pesanan</span>
                            @elseif ($formType == 3)
                            <span class="ml-3">Konfirmasi Pembayaran</span>
                            @endif
                            <i class="fas fa-arrow-right mr-3 text-capitalize"></i>
                        </a>
                    </h4>
                </div>
        </div>
        @endif
    </div>
</div>
</div>