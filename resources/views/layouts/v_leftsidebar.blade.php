<div class="card mb-3">
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

<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">
        <i class="bi bi-house me-2"></i> Beranda
    </a>
    <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-compass me-2"></i> Jelajahi
    </a>
    <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-bell me-2"></i> Notifikasi
    </a>
    <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-chat me-2"></i> Pesan
    </a>
    <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-plus-square me-2"></i> Buat Postingan
    </a>
</div>