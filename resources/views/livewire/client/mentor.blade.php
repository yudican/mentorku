<div class="page-inner">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-none">
                <div class="card-body">
                    @foreach ($categories as $category)
                    <h1 style="font-size:20px;"><b>{{$category->category_name}}</b></h1>
                    @foreach ($category->subCategories as $key => $item)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" wire:model="selected.{{$item->id}}"
                                value="{{$item->id}}">
                            <span class="form-check-sign">{{$item->subcategory_name}}</span>
                        </label>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                @foreach ($mentors as $mentor)
                <div class="col-md-6">
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
        </div>
    </div>
</div>