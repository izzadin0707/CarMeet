<div class="mb-3">
    <form action="{{ route("search") }}" method="post" class="input-group align-self-center" role="search">
        @csrf
        <span class="input-group-text rounded-start"><i class="bi bi-search"></i></span>
        <input class="form-control rounded-end" type="search" name="search" id="search" placeholder="Search" aria-label="Search">
    </form>
</div>
{{-- <div class="card mb-3">
    <div class="card-header">
        Saran Untuk Anda
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('default-profile.png') }}" 
                     class="rounded-circle me-3" 
                     style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">Pengguna 1</h6>
                    <small class="text-muted">@user1</small>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-primary">Ikuti</button>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('default-profile.png') }}" 
                     class="rounded-circle me-3" 
                     style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">Pengguna 2</h6>
                    <small class="text-muted">@user2</small>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-primary">Ikuti</button>
        </li>
    </ul>
</div> --}}

<div class="card">
    <div class="card-header">
        Event Terbaru
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">Konser Musik</h6>
                <small class="text-muted">20 Mei 2025</small>
            </div>
            <a href="#" class="btn btn-sm btn-outline-secondary">Lihat</a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">Pameran Seni</h6>
                <small class="text-muted">15 Juni 2025</small>
            </div>
            <a href="#" class="btn btn-sm btn-outline-secondary">Lihat</a>
        </li>
    </ul>
</div>