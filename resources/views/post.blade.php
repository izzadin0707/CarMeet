@extends('layouts.main')

@section('container')
    <div class="container-fluid">
        <div class="d-flex flex-column justify-content-center align-items-center">
          @if (count($creations) <= 0)
          <p class="fs-4">no creation available</p>
          @endif
          @foreach ($creations as $creation)
            <div class="card mb-4" style="width: 29rem;">
              @if ($creation->type_file == 'png')
              <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" class="card-img-top postImage" alt="..." style="max-height: 60vh;">
              @elseif ($creation->type_file == 'mp4')
              <video id="previewVideo" class="postVideo rounded-top">
                <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                Maaf, browser Anda tidak mendukung pemutaran video.
              </video>
              <div class="z-3" style="margin-top: -45px; margin-left: 5px;"><i class="bi bi-play fs-3 px-1 rounded-3" style="background-color: rgba(0, 0, 0, 0.5)"></i></div>
              @endif
              <div class="card-body">

                <div style="position: absolute; right: 0;">
                    @if ($likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first())
                    <a class="btn btn-outline btn-like" data-user-id="{{ $user->id }}" data-creation-id="{{ $creation->id }}" data-creation-user-id="{{ $creation->users->id }}"><i class="bi bi-heart-fill fs-5"></i></a>
                    @else
                    <a class="btn btn-outline btn-like" data-user-id="{{ $user->id }}" data-creation-id="{{ $creation->id }}" data-creation-user-id="{{ $creation->users->id }}"><i class="bi bi-heart fs-5"></i></a>
                    @endif
                  <div class="dropdown dropend">
                    <a class="btn" style="margin-top: -10px; margin-right: -2px; border: none;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical fs-5"></i>
                    </a>
                  
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item btn-comment" data-creation-id="{{ $creation->id }}"><i class="bi bi-chat-dots me-2"> </i> Comment</a></li>
                      @if ($saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first())
                      <li><a class="dropdown-item btn-save" data-user-id="{{ $user->id }}" data-creation-id="{{ $creation->id }}"><i class="bi bi-bookmark-fill me-2"> </i> Save</a></li>
                      @else
                      <li><a class="dropdown-item btn-save" data-user-id="{{ $user->id }}" data-creation-id="{{ $creation->id }}"><i class="bi bi-bookmark me-2"> </i> Save</a></li>
                      @endif
                      @if ($creation->users->username == $user->username)
                      <li><a class="dropdown-item" href="{{ url('/edit/'.$creation->creation) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                      <li><a class="dropdown-item" href="{{ url('/remove/'.$creation->creation) }}"><i class="bi bi-trash me-2"></i> Remove</a></li>
                      @else
                      <li><a class="dropdown-item" href="{{ route('report-creation-form', ['creation' => $creation->creation]) }}"><i class="bi bi-megaphone me-2"> </i> Report</a></li>
                      @endif
                    </ul>
                  </div>
                </div>
                
                <div style="width: 25rem;">
                  <h5 class="card-title">{{ $creation->title }}</h5>
                  @if ($creation->type_file == 'mp3')
                  <audio src="{{ asset('storage/'.$category.'/'.$creation->creation.'.'.$creation->type_file) }}" controls style="width: 100%; margin-left: -5px;"></audio>
                  @endif
                  <div style="max-height: 75px; margin-bottom: 5px; overflow-y: auto;">
                      <p class="card-text" id="description">{{ $creation->desc }}</p>
                  </div>
                  <p class="card-text"><small class="text-body-secondary">{{ $creation->created_at->diffForHumans() }}, creator : <a href="{{ url('profile/'.str_replace('#', '%23', $creation->users->username)) }}" class="text-decoration-none" style="color: var(--bs-body);">{{ $creation->users->name }}</a></small></p>
                </div>
              </div>
            </div>
          @endforeach

        </div>
    </div>
@endsection
