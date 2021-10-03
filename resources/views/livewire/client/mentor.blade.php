<div class="page-inner">
    @push('styles')
    <style>
        .search {
            border: 1px solid #ebedf2;
            border-left: 1px solid #fff;
        }

        .search2 {
            border: 1px solid #ebedf2;
            border-right: 1px solid #fff;
        }

        .btn-outline-secondary:hover {
            color: #000;
            background-color: transparent;
            background-image: none;
            border: 1px solid #ebedf2;
            border-left: 1px solid #fff;
        }

        .show>.btn-outline-secondary.dropdown-toggle {
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #ebedf2;
            border-right: 1px solid #fff;
        }

        .form-control:focus {
            font-size: 14px;
            border: 1px solid #ebedf2;
            border-right: 1px solid #fff;
            padding: .6rem 1rem;
            height: inherit !important;
        }
    </style>
    @endpush
    <div class="card  shadow-none">
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" wire:model="query" class="form-control" aria-label="Text input with dropdown button">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary search" wire:click="filter"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
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