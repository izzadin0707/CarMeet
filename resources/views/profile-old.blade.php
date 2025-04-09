@extends('layouts.main')

@section('container')
@if (session('message'))
<div class="d-flex justify-content-center">
    <div class="alert alert-success rounded-4" style="width: 150vh;">
        <span class="text-success-emphasis">{{ session('message') }}</span>
    </div>
</div>
@endif
@if (session('error'))
<div class="d-flex justify-content-center">
    <div class="alert alert-danger rounded-4" style="width: 150vh;">
        <span class="text-danger-emphasis">{{ session('error') }}</span>
    </div>
</div>
@endif
<div class="container border mt-3 rounded-4" style="max-width: 150vh;">
    <div class="row position-absolute">
        <div class="dropdown dropend" style="margin-left: -13px;">
            <a class="btn rounded-4" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical fs-5"></i>
            </a>
          
            <ul class="dropdown-menu">
                @if ($user->id == Auth::id())
                <li><a class="dropdown-item" href="{{ route('profile-setting') }}"><i class="bi bi-gear me-2"> </i> Profile Setting</a></li>
                <li><a class="dropdown-item" href="{{ route('saves') }}"><i class="bi bi-bookmark me-2"> </i> Save</a></li>
                <li><a class="dropdown-item" href="{{ route('likes') }}"><i class="bi bi-heart me-2"> </i> Likes</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left me-2"> </i> Logout</a></li>
                @else
                <li><a class="dropdown-item" href="{{ route('report-profile-form', ['profile' => $user->id]) }}"><i class="bi bi-megaphone me-2"> </i> Report</a></li>
                @endif
            </ul>
          </div>
    </div>
    @if (count($assets) !==  0)    
        @foreach ($assets as $asset)
            @if ($assets->where('status', 'banner')->count() !== 0)
                @if ($asset->status == 'banner')
                <div class="row rounded-top-4" style="background-image: url('{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}'); height: 20rem; background-size: cover; background-position: center; margin-bottom: -150px;"></div>    
                @endif
            @else
            <div class="row rounded-top-4" style="background-color: grey; height: 20rem; background-size: cover; background-position: center; margin-bottom: -150px;"></div>
            @endif
        @endforeach
    @else
        <div class="row rounded-top-4" style="background-color: grey; height: 20rem; background-size: cover; background-position: center; margin-bottom: -150px;"></div>
    @endif
    <div class="text-center">
        <div class="row pt-5 rounded-top profile-bg">
            <div class="col">
                
                @if (count($assets) !==  0)    
                    @foreach ($assets as $asset)
                        @if ($assets->where('status', 'photo-profile')->count() != 0)
                            @if ($asset->status == 'photo-profile')
                            <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">    
                            @endif
                        @else
                        <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                        @endif
                    @endforeach
                @else
                    <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                @endif

                <p class="fs-1 fw-semibold" style="margin-bottom: -1px">{{ $user->name }}</p>
                <p class="fs-6">{{ $user->username }}</p>
            </div>
        </div>
        <div class="row mt-4 mx-5">
            <div class="col">
                <p class="fs-2">{{ $posts }}</p>
            </div>
            <div class="col">
                <p class="fs-2">{{ $likes }}</p>
            </div>
        </div>
        <div class="row mx-5">
            <div class="col">
                <p class="fs-5">POST</p>
            </div>
            <div class="col">
                <p class="fs-5">LIKE</p>
            </div>
        </div>
        <div class="border mt-4 mb-3"></div>
        <div class="row row-cols-3 mb-3" id="creationCard">
            @foreach ($creations as $creation)
            <div class="col my-2">
              <a href="{{ url('post/'.$creation->creation) }}" class="text-decoration-none" style="color: var(--bs-body);">
                @if ($creation->type_file == 'png')
                <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" class="rounded rounded-3 border border-2" alt="..." style="height: 100%; width: 100%; object-fit: cover;">
                @elseif ($creation->type_file == 'mp4')
                <video id="previewVideo" class="rounded rounded-3 border border-2" style="height: 100%; width: 100%; object-fit: cover;">
                <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                  Maaf, browser Anda tidak mendukung pemutaran video.
                </video>
                <div style="margin-top: -50px; margin-left: 5px;" class="position-absolute"><i class="bi bi-play fs-4 px-2 py-1 align-top rounded" style="background-color: rgba(0, 0, 0, 0.7);"></i></div>
                @endif
              </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        if($("html").data('bg-color') !== undefined){
            $("html").attr('data-bs-theme', 'light');
            var bg = $("html").data('bg-color');
            var font = $("html").data('font-color');
            //Body
            $("body").css('background-color', bg);
            $("body").css('color', font);
            //Main
            $("#main *").css('color', `${font}`);
            //Navbar
            $("#myNavbar").css('background-color', bg);
            $("#myNavbar *").css('color', `${font}`);
            $("#myNavbar").removeClass('border-bottom');
            $("#myNavbar").css('border', `solid ${font}`);
            $("#myNavbar").css('border-width', `0px 0px 1px 0px`);
            $("#search").css('background-color', bg);
            $("#search").css('color', font);
            $("#search").css('border-color', `${font}`);
            //Sidebar
            $("#mySidebar").css('background-color', bg);
            $("#mySidebar").css('border-color', `${font}`);
            $("#mySidebar *").css('color', `${font}`);
            $("#profile").css('color', `${font}`);
            $(".profileBar").css('border-color', `${font}`);
            //Commentbar
            $("#myCommentbar").css('background-color', bg);
            $("#myCommentbar").css('border-color', `${font}`);
            $("#comment-bar").removeClass('border-bottom');
            $("#comment-bar").removeClass('border-top');
            $("#comment-bar").css('border', `solid ${font}`);
            $("#comment-bar").css('border-width', `1px 0px 1px 0px`);
            //Dropdown
            $(".dropdown-menu").css('background-color', bg);
            //Border
            $(".border").css('border', `1px solid ${font}`);
            $(".border").removeClass('border');
        }
    });
    </script>
@endsection
