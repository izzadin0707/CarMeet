@extends('layouts.main')

@section('content')
{{-- Posting Cepat --}}
<div class="card mb-3 shadow-sm border-0">
    <img src="{{ 
        $auth_assets->where('status', 'photo-profile')->first()
            ? URL::asset('storage/assets/' . $auth_assets->where('status', 'banner')->first()->asset . '.png') 
            : URL::asset('photo-profile.png') }}" 
        class="w-100 rounded-top-3" 
        style="height: 12rem; object-fit: cover;">
    <div class="card-body">
        <div class="d-flex mb-3">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
                class="rounded-circle me-3 border border-5 border-white" 
                style="width: 9rem; height: 9rem; object-fit: cover; margin-top: -5.5rem; ">
            <div class="d-flex justify-content-end w-100">
                <div>
                    <button class="btn btn-outline-secondary" onclick="openModalProfile()">Profile Setting</button>
                </div>
            </div>
        </div>
        <div>
            <span class="fs-2 fw-semibold">{{ $user->name }}</span>
            <div style="margin-top: -5px;">
                <small class="text-muted fs-6">{{ $user->username }}</small>
                <br>
                <small class="text-muted fs-6"><i class="bi bi-calendar me-2"></i> Joined at {{ date('F Y', strtotime($user->created_at)) }}</small>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between gap-3">
            <a href="{{ route('profile', 'posting') }}" class="btn {{ isset($page) && $page == 'posting' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill w-100">
                <span>Posting</span>
            </a>
            <a href="{{ route('profile', 'reply') }}" class="btn {{ isset($page) && $page == 'reply' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill w-100">
                <span>Reply</span>
            </a>
            <a href="{{ route('profile', 'media') }}" class="btn {{ isset($page) && $page == 'media' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill w-100">
                <span>Media</span>
            </a>
            <a href="{{ route('profile', 'like') }}" class="btn {{ isset($page) && $page == 'like' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill w-100">
                <span>Like</span>
            </a>
            <a href="{{ route('profile', 'save') }}" class="btn {{ isset($page) && $page == 'save' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill w-100">
                <span>Save</span>
            </a>
        </div>
    </div>
</div>


@if (isset($page) && $page == 'posting') 

{{-- Posting --}}
@if ($creations->where('user_id', $user->id)->count() <= 0)
    <p class="text-muted text-center mt-5">no content available</p>
@endif

@foreach ($creations->where('user_id', $user->id) as $creation)
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="w-100" >
                <div class="d-flex justify-content-between mb-2" style="cursor: pointer;">
                    <div class="w-100" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id]) }}'">
                        <div class="text-nowrap">
                            <a href="#" class="mb-0 fw-semibold text-decoration-none">{{ $creation->users->name }}</a>
                            @php
                                $crea = date('Y', strtotime($creation->created_at));
                                if (date('Y') == $crea) {
                                    $crea = date('d', strtotime($creation->created_at));
                                    if ( date('d') == $crea) {
                                        $crea = $creation->created_at->diffForHumans();
                                    } else {
                                        $crea = date('d M', strtotime($creation->created_at));
                                    }
                                } else {
                                    $crea = date('d M Y', strtotime($creation->created_at));
                                }
                            @endphp
                            <small class="text-muted"> • {{ $crea }} ({{ $creation->categorys->name }})</small>
                        </div>
                        @php
                            $token = csrf_token();
                            $desc = preg_replace_callback('/#(\w+)/', function ($match) use ($token) {
                                $tag = $match[1];
                                return '<a href="/?search=' . urlencode('#' . $tag) . '&_token=' . $token . '" class="text-primary">#' . $tag . '</a>';
                            }, e($creation->desc));
                        @endphp
                        <p class="card-text">{!! $desc !!}</p>
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
                                <li><a class="dropdown-item" href="#">Report</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                @isset($creation->creation)
                <div class="mb-3" style="cursor: pointer;" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id])}}'">
                    <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="Postingan" class="mw-100 rounded-3 border" style="max-height: 25rem;">
                </div>
                @endisset
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <button 
                            class="btn btn-link btn-like p-0 text-decoration-none text-danger me-2"
                            data-user-id="{{ $user->id }}" 
                            data-creation-id="{{ $creation->id }}" 
                            data-creation-user-id="{{ $creation->users->id }}">
                            <i class="bi {{ $likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            <span class="like-counts">{{ count($likes->where('creation_id', $creation->id)) }}</span>
                        </button>
                        <button class="btn btn-link p-0 text-decoration-none text-muted">
                            <i class="bi {{ $comments->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                            <span class="comment-counts">{{ count($comments->where('creation_id', $creation->id)) }}</span>
                        </button>
                    </div>
                    <button 
                        class="btn btn-link btn-save p-0 text-decoration-none text-muted"
                        data-user-id="{{ $user->id }}" 
                        data-creation-id="{{ $creation->id }}">
                        <i class="bi {{ $saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endif

@if (isset($page) && $page == 'reply')

{{-- Replay --}}
@if ($comments->where('user_id', $user->id)->count() <= 0)
    <p class="text-muted text-center mt-5">no content available</p>
@endif

@foreach ($comments as $comment)   
@if ($comment->user_id == $user->id)
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $comment->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="d-flex justify-content-between mb-2 w-100">
                <div class="w-100" style="cursor: pointer;" onclick="window.location.href='{{ route('post-detail', ['category' => $comment->creations->categorys->slug, 'id' => $comment->creations->id]) }}'">
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
                    <div class="text-nowrap">
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
                            <li><a class="dropdown-item" href="#">Report</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
    
@endif

@if (isset($page) && $page == 'media')

{{-- Media --}}
@if ($creations->whereNotNull('creation')->where('user_id', $user->id)->count() <= 0)
    <p class="text-muted text-center mt-5">no content available</p>
@else    
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-1">
            @foreach ($creations->whereNotNull('creation')->where('user_id', $user->id) as $creation)
            <div style="width: 32.9%;" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id])}}'">
                <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="media" class="w-100 h-100 rounded-3 media-img" style="object-fit: cover; cursor: pointer;">
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .media-img:hover {
        filter: brightness(0.8);
        transition: all 0.3s ease;
    }
</style>
@endif

@endif

@if (isset($page) && $page == 'like') 

{{-- Like --}}
@if ($likes->where('user_id', $user->id)->count() <= 0)
    <p class="text-muted text-center mt-5">no content available</p>
@endif

@foreach ($creations->whereIn('id', $likes->where('user_id', $user->id)->pluck('creation_id')) as $creation)
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="w-100" >
                <div class="d-flex justify-content-between mb-2" style="cursor: pointer;">
                    <div class="w-100" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id]) }}'">
                        <div class="text-nowrap">
                            <a href="#" class="mb-0 fw-semibold text-decoration-none">{{ $creation->users->name }}</a>
                            @php
                                $crea = date('Y', strtotime($creation->created_at));
                                if (date('Y') == $crea) {
                                    $crea = date('d', strtotime($creation->created_at));
                                    if ( date('d') == $crea) {
                                        $crea = $creation->created_at->diffForHumans();
                                    } else {
                                        $crea = date('d M', strtotime($creation->created_at));
                                    }
                                } else {
                                    $crea = date('d M Y', strtotime($creation->created_at));
                                }
                            @endphp
                            <small class="text-muted"> • {{ $crea }}</small>
                        </div>
                        @php
                            $token = csrf_token();
                            $desc = preg_replace_callback('/#(\w+)/', function ($match) use ($token) {
                                $tag = $match[1];
                                return '<a href="/?search=' . urlencode('#' . $tag) . '&_token=' . $token . '" class="text-primary">#' . $tag . '</a>';
                            }, e($creation->desc));
                        @endphp
                        <p class="card-text">{!! $desc !!}</p>
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
                                <li><a class="dropdown-item" href="#">Report</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                @isset($creation->creation)
                <div class="mb-3" style="cursor: pointer;" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id])}}'">
                    <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="Postingan" class="mw-100 rounded-3 border" style="max-height: 25rem;">
                </div>
                @endisset
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <button 
                            class="btn btn-link btn-like p-0 text-decoration-none text-danger me-2"
                            data-user-id="{{ $user->id }}" 
                            data-creation-id="{{ $creation->id }}" 
                            data-creation-user-id="{{ $creation->users->id }}">
                            <i class="bi {{ $likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            <span class="like-counts">{{ count($likes->where('creation_id', $creation->id)) }}</span>
                        </button>
                        <button class="btn btn-link p-0 text-decoration-none text-muted">
                            <i class="bi {{ $comments->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                            <span class="comment-counts">{{ count($comments->where('creation_id', $creation->id)) }}</span>
                        </button>
                    </div>
                    <button 
                        class="btn btn-link btn-save p-0 text-decoration-none text-muted"
                        data-user-id="{{ $user->id }}" 
                        data-creation-id="{{ $creation->id }}">
                        <i class="bi {{ $saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endif

@if (isset($page) && $page == 'save') 

{{-- Save --}}
@if ($saves->where('user_id', $user->id)->count() <= 0)
    <p class="text-muted text-center mt-5">no content available</p>
@endif

@foreach ($creations->whereIn('id', $saves->where('user_id', $user->id)->pluck('creation_id')) as $creation)
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
            class="rounded-circle me-3" 
            style="width: 40px; height: 40px; object-fit: cover;">
            <div class="w-100" >
                <div class="d-flex justify-content-between mb-2" style="cursor: pointer;">
                    <div class="w-100" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id]) }}'">
                        <div class="text-nowrap">
                            <a href="#" class="mb-0 fw-semibold text-decoration-none">{{ $creation->users->name }}</a>
                            @php
                                $crea = date('Y', strtotime($creation->created_at));
                                if (date('Y') == $crea) {
                                    $crea = date('d', strtotime($creation->created_at));
                                    if ( date('d') == $crea) {
                                        $crea = $creation->created_at->diffForHumans();
                                    } else {
                                        $crea = date('d M', strtotime($creation->created_at));
                                    }
                                } else {
                                    $crea = date('d M Y', strtotime($creation->created_at));
                                }
                            @endphp
                            <small class="text-muted"> • {{ $crea }}</small>
                        </div>
                        @php
                            $token = csrf_token();
                            $desc = preg_replace_callback('/#(\w+)/', function ($match) use ($token) {
                                $tag = $match[1];
                                return '<a href="/?search=' . urlencode('#' . $tag) . '&_token=' . $token . '" class="text-primary">#' . $tag . '</a>';
                            }, e($creation->desc));
                        @endphp
                        <p class="card-text">{!! $desc !!}</p>
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
                                <li><a class="dropdown-item" href="#">Report</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                @isset($creation->creation)
                <div class="mb-3" style="cursor: pointer;" onclick="window.location.href='{{ route('post-detail', ['category' => $creation->categorys->slug, 'id' => $creation->id])}}'">
                    <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="Postingan" class="mw-100 rounded-3 border" style="max-height: 25rem;">
                </div>
                @endisset
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <button 
                            class="btn btn-link btn-like p-0 text-decoration-none text-danger me-2"
                            data-user-id="{{ $user->id }}" 
                            data-creation-id="{{ $creation->id }}" 
                            data-creation-user-id="{{ $creation->users->id }}">
                            <i class="bi {{ $likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            <span class="like-counts">{{ count($likes->where('creation_id', $creation->id)) }}</span>
                        </button>
                        <button class="btn btn-link p-0 text-decoration-none text-muted">
                            <i class="bi {{ $comments->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                            <span class="comment-counts">{{ count($comments->where('creation_id', $creation->id)) }}</span>
                        </button>
                    </div>
                    <button 
                        class="btn btn-link btn-save p-0 text-decoration-none text-muted"
                        data-user-id="{{ $user->id }}" 
                        data-creation-id="{{ $creation->id }}">
                        <i class="bi {{ $saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endif

<div style="margin-bottom: 10rem;"></div>

<script>
$(document).ready(function() {
    // Media button click handler
    $('#mediaButton').on('click', function() {
        $('#mediaFileInput').click();
    });

    // File input change handler
    $('#mediaFileInput').on('change', function() {
        // Reset previous preview
        $('#imagePreview, #videoPreview').hide();
        $('#previewContainer').hide();

        var file = this.files[0];
        if (file) {
            // Show preview based on file type
            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('#videoPreview').hide();
                    $('#previewContainer').show();
                }
                reader.readAsDataURL(file);
            } else if (file.type.startsWith('video/')) {
                var videoURL = URL.createObjectURL(file);
                $('#videoPreview').attr('src', videoURL).show();
                $('#imagePreview').hide();
                $('#previewContainer').show();
            }
        }
    });

    // Remove preview handler
    $('#removePreview').on('click', function() {
        // Clear file input
        $('#mediaFileInput').val('');
        
        // Hide preview
        $('#previewContainer').hide();
        $('#imagePreview, #videoPreview').hide();
    });
});
</script>

@endsection