<div class="card mb-3 shadow-sm border-0">
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
                <h6 class="mb-0">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->username }}</small>
            </div>
        </div>
        {{-- <div class="d-flex justify-content-between">
            <small>Followers</small>
            <small>Following</small>
        </div>
        <div class="d-flex justify-content-between">
            <strong>0</strong>
            <strong>0</strong>
        </div> --}}
    </div>
</div>

<div class="list-group mb-3 shadow-sm">
    <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ isset($page) && $page == 'general' ? 'active' : '' }}">
        <i class="bi bi-chat-left-text me-2"></i> General
    </a>
    <a href="#" class="list-group-item list-group-item-action {{ isset($page) && $page == 'mods_tech' ? 'active' : '' }}">
        <i class="bi bi-tools me-2"></i>  Mods & Tech
    </a>
    <a href="#" class="list-group-item list-group-item-action {{ isset($page) && $page == 'car_showcase' ? 'active' : '' }}">
        <i class="bi bi-car-front-fill me-2"></i> Car Showcase
    </a>
    <a href="#" class="list-group-item list-group-item-action {{ isset($page) && $page == 'help_tips' ? 'active' : '' }}">
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
    {{-- <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-chat me-2"></i> Pesan
    </a> --}}
    <a href="#" class="list-group-item list-group-item-action" onclick="openModalPost()">
        <i class="bi bi-plus-square me-2"></i> Post
    </a>
</div>

{{-- <div class="card mb-3">
    <div class="card-header">
        <span class="fw-semibold">Channel</span>
    </div>
</div> --}}