<div class="page-inner">
    <div class="card  shadow-none">
        <div class="card-body">
            <x-text-field type="text" name="category_name" placeholder="Cari Mentor" />
            <div class="text-center">
                <h3 style="font-size: 14px;">Functional Area</h3>
                <div class="row text-center">
                    <div class="col-3 mx-auto">
                        <strong>
                            <h1 style="font-size: 16px;font-weight:bold;">Functional Area</h1>
                        </strong>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <h3 style="font-size: 14px;">Functional Area</h3>
                <div class="row text-center">
                    <div class="col-3 mx-auto">
                        <strong>
                            <h1 style="font-size: 16px;font-weight:bold;">Functional Area</h1>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron ">
        <div class="row">
            <div class="col-md-7">
                <h1 style="font-size:30px;"><b>Konsultasikan dengan ahlinya</b></h1>
                <p class="lead" style="font-weight: 500;">This is a simple hero unit, a simple jumbotron-style component
                    for calling extra
                    attention to
                    featured content or information.</p>
            </div>
            <div class="col-md-5 ml-auto text-right">
                <h1 style="font-size:30px;"><b>Grow <br> and <br> Move!</b></h1>
            </div>
        </div>
    </div>

    <div class="card  shadow-none" id="mentor">
        <div class="card-body">
            <h1 style="font-size:20px;" class="text-center pb-4"><b>Find Your Mentor</b></h1>
            <div class="row pt-4">
                @foreach ($mentors as $mentor)
                <div class="col-md-4">
                    <a href="{{route('mentor.detail', ['mentor_id' => $mentor->id])}}" class="text-decoration-none"
                        style="text-decoration: none;">
                        <div class="card  shadow-none text-decoration-none" style="width: 18rem;">
                            <iframe class="card-img border-0" src="{{$mentor->mentor_intruduction_url_vidio}}"></iframe>
                            <div class="card-body p-0">
                                <div class="media text-muted pt-3 align-items-center">
                                    <img src="{{$mentor->user->profile_photo_path ? asset('storage/'.$mentor->user->profile_photo_path) : asset('assets/img/default.png')}}"
                                        class="img-circle mr-4" alt="{{$mentor->user->name}}"
                                        style="height: 50px; border-radius:25px;">
                                    <p class="media-body mb-0 small lh-125 text-decoration-none"
                                        style="text-decoration: none;">
                                        <strong
                                            class="d-block text-gray-dark text-decoration-none">{{$mentor->user->name}}</strong>
                                        {{$mentor->mentor_keahlian}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class=" text-center">
                <a href="{{route('mentor')}}">
                    <button class="btn btn-primary btn-border btn-round">See All</button></a>
            </div>
        </div>
    </div>

    <div class="card  shadow-none" id="service">
        <div class="card-body">
            <h1 style="font-size:20px;" class="text-center mb-4"><b>Cukup 3 Langkah Mudah</b></h1>
            <div class="row mt-2 pt-4 justify-content-around">
                <div class="col-md-3">
                    <div class="card shadow-none" style="width: 18rem;">
                        <img class="card-img-top" height="200" src="{{asset('assets/img/client/1.svg')}}"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="media-body mb-0 small lh-125 text-center">
                                Sampaikan Problem anda melalui platform mentroku yang mudah digunakan
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-none" style="width: 18rem;">
                        <img class="card-img-top" height="200" src="{{asset('assets/img/client/2.svg')}}"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="media-body mb-0 small lh-125 text-center">
                                Agendakan pertemuan dengan expert rekomendasi kami
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-none" style="width: 18rem;">
                        <img class="card-img-top" height="200" src="{{asset('assets/img/client/3.svg')}}"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="media-body mb-0 small lh-125 text-center">
                                Selamat anda telah mendapatkan solusi dan analisa langsung dari expert
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="subscription">
        <h1 style="font-size:20px;" class="pb-4 text-center"><b>Subscription</b></h1>
        <div class="row px-3 pt-4">
            @foreach ($plans as $plan)
            <div class="col-md-4 pl-md-0">
                <div class="card card-pricing">
                    <div class="card-header">
                        <h4 class="card-title">{{$plan->plan_title}}</h4>
                        <div class="card-price">
                            <span class="price">Rp. {{number_format($plan->plan_price)}}</span>
                            {{-- <span class="text">/mo</span> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="specification-list">
                            <li>
                                <span class="name-specification">Mentor/{{$plan->plan_max_type}}</span>
                                <span class="status-specification">{{$plan->plan_max_mentor}}</span>
                            </li>
                            <li>
                                <span class="name-specification">Durasi</span>
                                <span class="status-specification">{{$plan->plan_duration}}/Hari</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('subscription', ['plan_id' => $plan->id])}}">
                            <button class="btn btn-secondary btn-block"><b>Subscribe</b></button>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>