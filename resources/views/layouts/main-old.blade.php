<!DOCTYPE html>
@if(isset($color) || isset($font))
<html lang="en" id="htmlMode" data-bs-theme="light" data-bg-color="{{ $color }}" data-font-color="{{ $font }}">
@else
<html lang="en" id="htmlMode" data-bs-theme="light">
@endisset

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('style/js/script.js') }}"></script>
    <title>CarMeet</title>
</head>
{{-- loading --}}
<div class="loading container-fluid d-flex justify-content-center align-items-center">
    <i class="bi bi-arrow-clockwise fs-1"></i>
</div>
{{-- full_img --}}
<div class="modalImg container-fluid d-flex justify-content-center align-items-center">
    <div style="overflow-x: auto;">
        <button class="btn" style="color: white;" id="closeImg"><i class="bi bi-x fs-1"></i></button>
        <img src="" id="fullImg" alt="">
    </div>
</div>
{{-- full_video --}}
<div class="modalVideo container-fluid d-flex justify-content-center align-items-center">
    <div style="overflow-x: auto;">
        <button class="btn" style="color: white;" id="closeVideo"><i class="bi bi-x fs-1"></i></button>
        <video src="" id="fullVideo" controls autoplay muted>
    </div>
</div>
<body>
    <div class="container-fluid">
        <div class="row">
            {{-- navbar --}}
            <nav class="navbar border-bottom fixed-top" id="myNavbar" style="background-color: var(--bs-body-bg);">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="row w-100">
                        <div class="col-2 col-md-1 align-self-center">
                            <button class="btn" id="sidebarToggle"><i class="bi bi-list fs-4"></i></button>
                        </div>
                        <div class="col-8 col-md-10 d-flex justify-content-center">
                            <form action="{{ route("search") }}" method="post" class="d-flex input-group align-self-center search_input" role="search">
                                @csrf
                                <input class="form-control rounded text-center" type="search" name="search" id="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                        {{-- <div class="col-2 col-md-1 align-self-center text-end">
                            <button class="btn" id="darkmodeToggle"><i id="darkIcon" class="bi bi-moon-fill fs-4"></i></button>
                        </div> --}}
                    </div>
                </div>
            </nav>
            {{-- side-bar --}}
            <nav class="col-md-3 col-lg-2 sidebar" id="mySidebar">
                <button class="btn mx-3" id="closeSidebar" style="float: right; border: none;"><i class="bi bi-x fs-4"></i></button>
                <h1 class="mx-3" style="cursor: pointer;" id="home">CarMeet</h1>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/upload"><i class="bi bi-plus-lg fs-5" style="margin-right: 7px;"></i> Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('likes') }}"><i class="bi bi-calendar-plus fs-5" style="margin-right: 7px;"></i> Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="categoryToggle"><i class="bi bi-tag fs-5" style="margin-right: 7px;"></i> Category</a>
                    </li>
                    <li>
                        <div class="category-list ms-4">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link fs-6" href="/category/art"><i class="bi bi-pencil fs-5" style="margin-right: 7px;"></i> Mercy</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-6" href="/category/animation"><i class="bi bi-film fs-5" style="margin-right: 7px;"></i> BMW</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-6" href="/category/design"><i class="bi bi-vector-pen fs-5" style="margin-right: 7px;"></i> Honda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-6" href="/category/music"><i class="bi bi-headphones fs-5" style="margin-right: 7px;"></i> Toyota</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('saves') }}"><i class="bi bi-bookmark fs-5" style="margin-right: 7px;"></i> Save</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('likes') }}"><i class="bi bi-heart fs-5" style="margin-right: 7px;"></i> Like</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile-setting') }}"><i class="bi bi-gear fs-5" style="margin-right: 7px;"></i> Setting</a>
                    </li>
                    @auth
                    @if (Auth::user()->roles == 1)    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-inboxes fs-5" style="margin-right: 7px;"></i> Dashboard</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left fs-5" style="margin-right: 7px;"></i> Logout</a>
                    </li>
                    @endauth
                </ul>
                <div class="profileBar d-flex align-items-center pt-1 bg-white">
                    <a href="/profile" class="fs-2">
                        <div class="d-flex justify-content-center">
                            <div>
                                @if ($auth_assets->count() !== 0)
                                @foreach ($auth_assets as $asset)
                                @if ($asset->status == "photo-profile")
                                <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="" class="rounded-circle" style="width: 67px; height: 67px; object-fit: cover;">
                                @endif    
                                @endforeach
                                @else
                                <img src="{{ URL::asset('photo-profile.png') }}" alt="" class="rounded-circle" style="width: 67px; height: 67px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="align-self-center ms-3" id="profile">
                                Profile
                            </div>
                        </div>
                    </a>
                </div>
            </nav>
            {{-- main --}}
            <main class="z-3" style="margin-top: 100px; margin-bottom: 100px;" id="main">
                @yield('container')
            </main>
            {{-- comment-bar --}}
            <nav class="col-md-3 col-lg-2 commentbar" id="myCommentbar">
                <button class="btn mx-1" id="closeCommentbar" style="border: none; margin-top: -7px; margin-bottom: 7px;"><i class="bi bi-x fs-4"></i></button>
                <div class="border-top border-bottom mt-1 overflow-y-auto h-75" id="comment-bar">
                    
                </div>
                <div class="p-2">
                    <textarea name="comment" id="comment" class="form-control mb-1" placeholder="Comment Here" style="height: 65px; width: 100%;" required></textarea>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-secondary mt-1" id="btn-comment">Send</button>
                    </div>
                    <input type="hidden" name="creation_id" value="" id="comment_creation_id">
                </div>
            </nav>
        </div>
    </div>
</body>

</html>