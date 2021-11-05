<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <section class="card mt-4">
                <div class="list-group list-group-messages list-group-flush">
                    @foreach ($chats as $chat)
                    <div class="list-group-item unread">
                        <div class="list-group-item-figure">
                            @if ($role == 'mentor')
                            <a href="{{route('chat.detail',['chat_id' =>$chat->id])}}" class="user-avatar">
                                <div class="avatar avatar-online">
                                    <img src="{{$chat->user->profile_photo_url}}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            @else
                            <a href="{{route('chat.detail',['chat_id' =>$chat->id])}}" class="user-avatar">
                                <div class="avatar avatar-online">
                                    <img src="{{$chat->mentor->profile_photo_url}}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            @endif

                        </div>
                        <div class="list-group-item-body pl-3 pl-md-4">
                            <div class="row">
                                <div class="col-12 col-lg-10">
                                    @if ($role == 'mentor')
                                    <h4 class="list-group-item-title">
                                        <a
                                            href="{{route('chat.detail',['chat_id' =>$chat->id])}}">{{$chat->user->name}}</a>
                                    </h4>
                                    @else
                                    <h4 class="list-group-item-title">
                                        <a
                                            href="{{route('chat.detail',['chat_id' =>$chat->id])}}">{{$chat->mentor->name}}</a>
                                    </h4>
                                    @endif

                                    <p class="list-group-item-text text-truncate"> {{$chat->last_chat->pesan}} </p>
                                </div>
                                <div class="col-12 col-lg-2 text-lg-right">
                                    <p class="list-group-item-text"> {{$chat->last_chat->created_at->diffForHumans()}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </section>
        </div>
    </div>
</div>