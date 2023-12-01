@extends('layouts.main')

@section('container')
  <div class="container">
    {{-- Saves --}}
    <div class="mb-4">
      <p class="fs-4">Save</p>
      <div class="row row-cols-md-6 row-cols-sm-3 row-cols-2" id="creationCard">
        @foreach ($creations as $creation)
          @foreach ($saves as $save)
            @if ($save->user_id == Auth::id() && $save->creation_id == $creation->id)
                
              <div class="col my-3 mb-5">
                @if ($creation->type_file == 'png')
            <a href="{{  url('post/'.$creation->creation) }}" class="text-decoration-none">
              <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" class="rounded rounded-3 border border-2" alt="..." style="height: 100%; width: 100%; object-fit: cover;">
            </a>
          @elseif ($creation->type_file == 'mp4')
            <a href="{{  url('post/'.$creation->creation) }}" class="text-decoration-none">
              <video id="previewVideo" class="rounded rounded-3 border border-2" style="height: 100%; width: 100%; object-fit: cover;">
                <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                  Maaf, browser Anda tidak mendukung pemutaran video.
              </video>
              <div style="margin-top: -50px; margin-left: 5px;" class="position-absolute"><i class="bi bi-play fs-4 px-2 py-1 align-top rounded" style="background-color: rgba(0, 0, 0, 0.7);"></i></div>
            </a>
          @endif
          @if ($assets->where('user_id', '=', $creation->user_id)->where('status', '=', 'photo-profile')->count() > 0)
          <a href="{{ url('profile/'.str_replace('#', '%23', $creation->users->username)) }}" class="fw-bold text-decoration-none" id="home_title"><div class="mt-2"><img src="{{ URL::asset('storage/assets/'. $assets->where('user_id', '=', $creation->user_id)->where('status', '=', 'photo-profile')->pluck('asset')->first() .'.png') }}" class="border me-2 rounded-circle object-fit-cover" id="profile_icon" alt="">{{ $creation->users->name }}</div></a>
          @else
          <a href="{{ url('profile/'.str_replace('#', '%23', $creation->users->username)) }}" class="fw-bold text-decoration-none" id="home_title"><div class="mt-2"><img src="{{ URL::asset('photo-profile.png') }}" class="border me-2 rounded-circle object-fit-cover" id="profile_icon" alt="">{{ $creation->users->name }}</div></a>
          @endif
              </div>
            @endif
          @endforeach
        @endforeach
      </div>
    </div>
    </div>
  </div>
@endsection
