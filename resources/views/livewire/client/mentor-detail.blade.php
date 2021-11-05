<div class="page-inner">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-none text-decoration-none" style="width: 25rem;">
                <iframe class="card-img border-0" style="height: 15rem;"
                    src="{{$mentor->mentor_intruduction_url_vidio}}"></iframe>
                <div class="card-body p-0">
                    <div class="media text-muted pt-3 align-items-center">
                        <img src="{{$mentor->user->profile_photo_path ? asset('storage/'.$mentor->user->profile_photo_path) : asset('assets/img/default.png')}}"
                            class="img-circle mr-4" alt="{{$mentor->user->name}}"
                            style="height: 50px; border-radius:25px;">
                        <p class="media-body mb-0 small lh-125 text-decoration-none" style="text-decoration: none;">
                            <strong class="d-block text-gray-dark text-decoration-none">{{$mentor->user->name}}</strong>
                            {{$mentor->mentor_keahlian}}
                        </p>
                        @if (Auth::check())
                        <button type="button" wire:click="startChat('{{$mentor->user->id}}')"
                            class="btn btn-danger btn-sm">Diskusi</button>
                        @endif
                    </div>
                    <p class="pt-2">{{$mentor->mentor_description}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <x-textarea type="text" name="schedule_topic" label="Topic" />
            <x-text-field type="date" name="schedule_date" label="Date" />
            <x-select name="schedule_duration" label="Duration">
                <option value="">Select Duration</option>
                <option value="1">1 hour</option>
                <option value="2">2 hour</option>
                <option value="3">3 hour</option>
            </x-select>

            @if (Auth::check())
            <div class="form-group">
                <button type="button" wire:click="makeSchedule" class="btn btn-danger btn-sm">Make Schedule</button>
            </div>
            @else
            <div class="form-group">
                <p>Silahkan login untuk membuat schedule</p>
            </div>
            @endif

        </div>
    </div>
</div>
</div>