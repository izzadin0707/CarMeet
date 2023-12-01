@extends('dashboard.layouts.main')

@section('main')
<div class="row row-cols-2">
    <div class="col mb-3">
        <a href="{{ route('dashboard-reports') }}" class="text-decoration-none">
            <div class="card border-0 shadow" style="height: 17vw;">
                <div class="card-body py-3">
                    <h3 class="card-title"><i class="bi bi-megaphone fs-2 me-2"></i>Reports</h3>
                    <div class="h-75 fw-semibold d-flex align-items-center justify-content-between" style="font-size: 75px;">
                        <p>{{ $reports->count() }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col mb-3">
        <a href="{{ route('dashboard-users') }}" class="text-decoration-none">
            <div class="card border-0 shadow" style="height: 17vw;">
                <div class="card-body py-3">
                    <h3 class="card-title"><i class="bi bi-people fs-2 me-2"></i>Users</h3>
                    <div class="h-75 fw-semibold d-flex align-items-center justify-content-between" style="font-size: 75px;">
                        <p>{{ $users }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col mb-3">
        <a href="{{ route('dashboard-creations') }}" class="text-decoration-none">
            <div class="card border-0 shadow" style="height: 17vw;">
                <div class="card-body py-3">
                    <h3 class="card-title"><i class="bi bi-pen fs-2 me-2"></i>Creations</h3>
                    <div class="h-75 fw-semibold d-flex align-items-center justify-content-between" style="font-size: 75px;">
                        <p>{{ $creations }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col mb-3">
        <a href="{{ route('dashboard-comments') }}" class="text-decoration-none">
            <div class="card border-0 shadow" style="height: 17vw;">
                <div class="card-body py-3">
                    <h3 class="card-title"><i class="bi bi-chat-dots fs-2 me-2"></i>Comments</h3>
                    <div class="h-75 fw-semibold d-flex align-items-center justify-content-between" style="font-size: 75px;">
                        <p>{{ $comments }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection