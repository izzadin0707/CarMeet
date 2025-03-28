@extends('layouts.main')

@section('container')
  <div class="container">
    {{-- Events --}}
    @if (count($events) > 0)
    <div class="mb-4">
      <div>
          @for ($i = 0; $i < count($events); $i++)
          <?php
            $event = $events[$i]
          ?>
          <div class="mx-2 row rounded-4 border event-banner {{ $i == 0 ? 'first-banner' : '' }} {{ $i == count($events) - 1 ? 'last-banner' : ''}}" data-slide="{{$i + 1}}" style="{{ $i > 0 ? 'display: none;' : ''}}  background-image: url('{{ URL::asset('storage/events/'.$event->asset.'.png') }}'); height: 20rem; background-size: cover; background-position: center; cursor: default;">
            <div class="rounded-4" style="position: relative; background: rgba(0, 0, 0, 0.5); color: white; opacity: 0; transition: .3s ease-in-out;">
              <div style="position: absolute; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); text-align: center; user-select: none;">
                <h1>{{ $event->title }}</h1>
                <h5>{{ $event->desc}}</h5>
                <span>{{date('Y F d', strtotime($event->start_date))}}  -  {{date('Y F d', strtotime($event->end_date))}}</span>
              </div>
              <div class="position-absolute h-100 d-flex align-items-center p-2 next-btn" style="left: 0; z-index: 4; cursor: pointer;">
                <h1><i class="bi bi-caret-left-fill"></i></h1>
              </div>
              <div class="position-absolute h-100 d-flex align-items-center p-2 prev-btn" style="right: 0;z-index: 4; cursor: pointer;">
                <h1><i class="bi bi-caret-right-fill"></i></h1>
              </div>
            </div>
          </div>
          @endfor
        </div>
      </div>
    @endif
    {{-- Latest Update --}}
    <div class="mb-4">
      <a href="{{ url('posts') }}" class="fs-4 text-decoration-none">Latest Update</a>
      <div class="row row-cols-md-6 row-cols-sm-3 row-cols-2" id="creationCard">
        @foreach ($creations as $creation)
        <div class="col my-3 mb-5">
          @if ($creation->type_file == 'png')
            <a href="{{  url('post/'.$creation->creation) }}" class="text-decoration-none">
              <img src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" class="rounded rounded-3 border border-2" alt="..." style="height: 100%; width: 100%; object-fit: cover;">
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
        @endforeach
      </div>
    </div>
    {{-- Your Creations --}}
    <div class="mb-4">
      <a href="{{ url('profile') }}" class="fs-4 text-decoration-none">Your Creations</a>
      <div class="row row-cols-md-6 row-cols-sm-3 row-cols-2" id="creationCard">
        @foreach ($creations as $creation)
        @if ($creation->user_id == Auth::id())    
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
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      $('.event-banner').on('mouseenter', function () {
        $('> div', this).css('opacity', '1')  
      })

      $('.event-banner').on('mouseleave', function () {
        $('> div', this).css('opacity', '0')  
      })

      $('.event-banner .next-btn').on('click', function () {
        parent = $(this).parents('.event-banner')
        if ($(parent).hasClass('first-banner')) {
          $('.event-banner').css('display', 'none')
          $('.event-banner.last-banner').css('display', 'flex')
        } else {
          $('.event-banner').css('display', 'none')
          $(`.event-banner[data-slide="${$(parent).data('slide') - 1}"]`).css('display', 'flex')
        }
      })

      $('.event-banner .prev-btn').on('click', function () {
        parent = $(this).parents('.event-banner')
        if ($(parent).hasClass('last-banner')) {
          $('.event-banner').css('display', 'none')
          $('.event-banner.first-banner').css('display', 'flex')
        } else {
          $('.event-banner').css('display', 'none')
          $(`.event-banner[data-slide="${$(parent).data('slide') + 1}"]`).css('display', 'flex')
        }
      })
    })
  </script>
@endsection
