<div class="card mb-3 shadow-sm border-0" style="cursor: pointer;" onclick="window.location.href='{{ route('profile') }}'">
    <div class="card-body">
        <div class="d-flex align-items-center mb-03">
            <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
                alt="Profile" 
                class="rounded-circle me-3" 
                style="width: 50px; height: 50px; object-fit: cover;">
            <div>
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ Auth::user()->username }}</small>
            </div>
        </div>
    </div>
</div>

<div class="list-group mb-3 shadow-sm">
    <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'general' ? 'active' : '' }}">
        <i class="bi bi-chat-left-text me-2"></i> General
    </a>
    <a href="{{ route('home', ['category' => 'modstech']) }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'modstech' ? 'active' : '' }}">
        <i class="bi bi-tools me-2"></i>  Mods & Tech
    </a>
    <a href="{{ route('home', ['category' => 'carshowcase']) }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'carshowcase' ? 'active' : '' }}">
        <i class="bi bi-car-front-fill me-2"></i> Car Showcase
    </a>
    <a href="{{ route('home', ['category' => 'helptips']) }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'helptips' ? 'active' : '' }}">
        <i class="bi bi-question-circle me-2"></i> Help & Tips
    </a>
</div>

<div class="list-group mb-3 shadow-sm">
    <a href="{{ route('home', ['search' => '', '_token' => csrf_token()]) }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'explore' ? 'active' : '' }}">
        <i class="bi bi-compass me-2"></i> Explore
    </a>
    <a href="{{ route('event') }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'event' ? 'active' : '' }}">
        <i class="bi bi-calendar me-2"></i> Event
    </a>
    @auth
    @if (Auth::user()->roles == 1)
    <a href="{{ route('report') }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'report' ? 'active' : '' }}">
        <i class="bi bi-megaphone me-2"></i> Report 
        @if ($reportAll > 0)
        <span class="ms-1">({{ $reportAll }})</span>
        @endif
    </a>
    @endif
    @endauth
    <a href="#" class="list-group-item list-group-item-action" onclick="openModalPost()">
        <i class="bi bi-plus-square me-2"></i> Post
    </a>
</div>


@auth
<div class="list-group mb-3 shadow-sm">
    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'explore' ? 'active' : '' }}">
        <i class="bi bi-box-arrow-left me-2"></i> Log out
    </a>
</div>
@endauth