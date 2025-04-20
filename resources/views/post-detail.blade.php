@extends('layouts.main')

@section('content')
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        @php
            $previousUrl = url()->previous();
            $currentUrl = url()->current();
            $backUrl = $previousUrl === $currentUrl ? route('home', ['category' => $page]) : $previousUrl;
        @endphp
        <a href="{{ $backUrl }}" class="text-decoration-none"><i class="bi bi-arrow-left me-2"></i> <span class="fw-semibold">Back</span></a>
    </div>
</div>

{{-- Post Detail --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="d-flex justify-content-between mb-2 w-100">
                <div>
                    <div class="d-flex flex-column text-nowrap" style="cursor: pointer;" onclick="window.location.href='{{ route('profile', ['username' => urlencode($creation->users->username)]) }}'">
                        <span class="mb-0 fw-semibold fs-5" style="margin-top: -5px">{{ $creation->users->name }}</span>
                        <small class="mb-0 text-muted" style="margin-top: -5px">{{ $creation->users->username }}</small>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-muted px-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        @if ($creation->user_id == $user->id)
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="openModalDelete('{{ route('delete') }}', 'POST', {creation: {{ $creation->id }}})">
                                    Delete
                                </a>
                            </li>
                        @endif
                        <li>
                            <a 
                            class="dropdown-item btn-save" 
                            href="#" 
                            data-user-id="{{ $user->id }}" 
                            data-creation-id="{{ $creation->id }}">
                                Save
                            </a>
                        </li>
                        @if ($creation->user_id != $user->id)
                            <li><a class="dropdown-item" href="#" onclick="openModalReport('creation', {{ $creation->id }})">Report</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-100 mt-2">
            @php
                $token = csrf_token();
                $desc = preg_replace_callback('/#(\w+)/', function ($match) use ($token) {
                    $tag = $match[1];
                    return '<a href="/?search=' . urlencode('#' . $tag) . '&_token=' . $token . '" class="text-primary">#' . $tag . '</a>';
                }, e($creation->desc));
            @endphp
            <p class="card-text">{!! $desc !!}</p>
            @isset($creation->creation)
            <div class="mb-3">
                <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="Postingan" class="mw-100 rounded-3 border">
            </div>
            @endisset
            <small class="text-muted">{{ date('h:i A • d M Y', strtotime($creation->created_at)) }}</small>
            <hr>
            <div class="d-flex justify-content-between mb-2 w-100 w-xl-25">
                <button class="btn btn-link p-0 text-decoration-none text-muted">
                    <i class="bi {{ $comments->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                    <span class="comment-counts">{{ count($comments->where('creation_id', $creation->id)) }}</span>
                </button>
                <button 
                    class="btn btn-link btn-like p-0 text-decoration-none text-danger me-2"
                    data-user-id="{{ $user->id }}" 
                    data-creation-id="{{ $creation->id }}" 
                    data-creation-user-id="{{ $creation->users->id }}">
                    <i class="bi {{ $likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    <span class="like-counts">{{ count($likes->where('creation_id', $creation->id)) }}</span>
                </button>
                <button 
                    class="btn btn-link btn-save p-0 text-decoration-none text-muted"
                    data-user-id="{{ $user->id }}" 
                    data-creation-id="{{ $creation->id }}">
                    <i class="bi {{ $saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    <span class="like-counts">{{ count($saves->where('creation_id', $creation->id)) }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="w-100">
                <form action="{{ route('comment') }}" method="post">
                    @csrf
                    <input type="hidden" name="creation_id" value="{{ $creation->id }}">
                    <div class="text-nowrap">
                        <span class="mb-0 fw-semibold">{{ $user->name }}</span>
                    </div>
                    <textarea 
                        name="desc" 
                        id="desc" 
                        class="form-control mt-2 w-100" 
                        rows="1" 
                        placeholder="Comment Here" 
                        oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
                    ></textarea>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-2">Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($comments as $comment)   
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $assets->where('user_id', '-', $comment->user_id)->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $comment->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="d-flex justify-content-between mb-2 w-100">
                <div>
                    @php
                        $crea = date('Y', strtotime($comment->created_at));
                        if (date('Y') == $crea) {
                            $crea = date('d', strtotime($comment->created_at));
                            if ( date('d') == $crea) {
                                $crea = $comment->created_at->diffForHumans();
                            } else {
                                $crea = date('d M', strtotime($comment->created_at));
                            }
                        } else {
                            $crea = date('d M Y', strtotime($comment->created_at));
                        }
                    @endphp
                    <div class="text-nowrap" style="cursor: pointer;" onclick="window.location.href='{{ route('profile', ['username' => urlencode($comment->users->username)]) }}'">
                        <span class="mb-0 fw-semibold">{{ $comment->users->name }}</span>
                        <small class="text-muted"> • {{ $crea }}</small>
                    </div>
                    @php
                        $token = csrf_token();
                        $desc = preg_replace_callback('/#(\w+)/', function ($match) use ($token) {
                            $tag = $match[1];
                            return '<a href="/?search=' . urlencode('#' . $tag) . '&_token=' . $token . '" class="text-primary">#' . $tag . '</a>';
                        }, e($comment->desc));
                    @endphp
                    <p class="card-text">{!! $desc !!}</p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-muted px-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        @if ($comment->user_id == $user->id)
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="openModalDelete('{{ route('remove-comment') }}', 'POST', {comment_id: {{ $comment->id }}})">
                                    Delete
                                </a>
                            </li>
                        @endif
                        @if ($comment->user_id != $user->id)
                            <li><a class="dropdown-item" href="#" onclick="openModalReport('comment', {{ $comment->id }})">Report</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div style="margin-bottom: 10rem;"></div>

@endsection