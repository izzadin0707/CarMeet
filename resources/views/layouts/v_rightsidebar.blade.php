<div class="mb-3 shadow-sm">
    <form action="{{ route("home") }}" method="get" class="input-group align-self-center" role="search">
        <span class="input-group-text rounded-start"><i class="bi bi-search"></i></span>
        <input class="form-control rounded-end" type="search" name="search" id="search" placeholder="Search" aria-label="Search">
        @csrf
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Event Terbaru</span>
        <a href="{{ route('event') }}" class="text-primary text-decoration-none" style="font-size: .85rem">See More</a>
    </div>
    @if($eventsAll->isEmpty())
        <div class="card-body text-center text-muted">
            <p class="mb-0">No events available</p>
        </div>
    @else
        <ul class="list-group list-group-flush">
            @foreach ($eventsAll as $event)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">{{ $event->title }}</h6>
                    <small class="text-muted">{{date('d F Y', strtotime($event->start_date))}}</small>
                </div>
                <a href="{{ route('event-detail', ['id' => $event->id]) }}" class="btn btn-sm btn-outline-secondary">See</a>
            </li>
            @endforeach
        </ul>
    @endif
</div>