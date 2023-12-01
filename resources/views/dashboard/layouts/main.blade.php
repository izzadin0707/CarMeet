<!DOCTYPE html>
<html lang="en" id="htmlMode" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('style/js/script.js') }}"></script>
    <title>LookME | Dashboard</title>
</head>
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
        <div class="row vh-100">
            <div class="col-2 px-2 pt-4 shadow bg-light z-3">
                <div class="text-center">
                    <a href="{{ route('dashboard') }}"><img src="{{ URL::asset('LookMeLogo.png') }}" alt="" class="w-50" style="margin-bottom: -20px;"></a>
                    <a href="{{ route('dashboard') }}" class="fs-2 fw-semibold text-decoration-none">LookME</a>
                </div>
                <div class="d-flex flex-column mt-3">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none mb-3 px-3 rounded-5 {{ ($url == 'home') ? 'bg-primary text-white py-1 fs-5' : 'fs-6' }}"><i class="bi bi-house me-3"></i>Home</a>
                    <a href="{{ route('dashboard-reports') }}" class="text-decoration-none mb-3 px-3 rounded-5 {{ ($url == 'reports') ? 'bg-primary text-white py-1 fs-5' : 'fs-6' }}"><i class="bi bi-megaphone me-3"></i>Reports</a>
                    <a href="{{ route('dashboard-users') }}" class="text-decoration-none mb-3 px-3 rounded-5 {{ ($url == 'users') ? 'bg-primary text-white py-1 fs-5' : 'fs-6' }}"><i class="bi bi-people me-3"></i>Users</a>
                    <a href="{{ route('dashboard-creations') }}" class="text-decoration-none mb-3 px-3 rounded-5 {{ ($url == 'creations') ? 'bg-primary text-white py-1 fs-5' : 'fs-6' }}"><i class="bi bi-pen me-3"></i>Creations</a>
                    <a href="{{ route('dashboard-comments') }}" class="text-decoration-none mb-3 px-3 rounded-5 {{ ($url == 'comments') ? 'bg-primary text-white py-1 fs-5' : 'fs-6' }}"><i class="bi bi-chat-dots me-3"></i>Comments</a>
                </div>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12 shadow bg-light">
                        <nav class="navbar">
                            <div class="container-fluid">
                                <a class="navbar-brand text-uppercase">WELCOME {{ Auth::guard('admin')->user()->name }}</a>
                                <div class="dropstart">
                                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="d-flex">
                                            @if ($reports->where('read', 0)->count() > 0)    
                                            <div class="bg-danger rounded-circle text-center text-light z-3" style="width: 13px; height: 13px; margin-right: -10px;"></div>
                                            @endif
                                            @if ($auth_assets->count() !== 0)
                                            @foreach ($auth_assets as $asset)
                                            @if ($asset->status == "photo-profile")
                                            <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="" class="rounded-circle border" style="width: 55px; height: 55px; object-fit: cover;">
                                            @endif    
                                            @endforeach
                                            @else
                                            <img src="{{ URL::asset('photo-profile.png') }}" alt="" class="rounded-circle border" style="width: 55px; height: 55px; object-fit: cover;">
                                            @endif
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('dashboard-reports') }}">Reports{{ ($reports->where('read', 0)->count() > 0) ? "[".$reports->where('read', 0)->count()."]" : "" }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('dashboard-logout') }}">Logout</a></li>
                                        <li><a class="dropdown-item" href="{{ route('home') }}">Back to LookME</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-12 p-4">
                        @yield('main')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>