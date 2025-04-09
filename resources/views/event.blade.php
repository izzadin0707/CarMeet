@extends('layouts.main')

@section('content')
{{-- Search --}}
<div class="card mb-3 shadow-sm border-0">
  <div class="card-body">
    <div class="d-flex align-items-center gap-4">
        <div style="cursor: pointer;" onclick="window.location.href='{{ route('home') }}'">
            <i class="bi bi-arrow-left"></i>
        </div>
        <form action="{{ route("event") }}" method="get" class="input-group align-self-center" role="search">
            @csrf
            <span class="input-group-text rounded-start"><i class="bi bi-search"></i></span>
            <input class="form-control rounded-end" type="search" name="search" id="search" placeholder="Search Event" aria-label="Search" value="{{ request('search') }}">
        </form>
    </div>
  </div>
</div>

{{-- Create Event --}}
<a href="{{ route('event-form') }}" class="btn btn-outline-primary w-100 fs-6 mb-3 pt-1 pb-2">Create your own event</a>

{{-- Feed Postingan --}}
@if (count($events) <= 0)
  <p class="text-muted text-center">no content available</p>
@endif

<div class="d-flex justify-content-between flex-wrap">
    @foreach ($events as $event)
    
    <div class="card mb-3 shadow-sm border-0 position-relative" style="width: 49%;">
        <div class="position-absolute end-0 top-0" style="margin: 10px;">
            <div class="bg-white pb-2 rounded-2 shadow-sm text-center fw-semibold" style="width: 3.2rem;">
                <div style="margin-bottom: -12px;">
                    <span style="font-size: 1.9rem;">{{ date('d', strtotime($event->start_date)) }}</span>
                </div>
                <div>
                    <span style="font-size: .9rem;">{{ date('M', strtotime($event->start_date)) }}</span>
                </div>
            </div>
        </div>
        <img src="{{ URL::asset('storage/events/'.$event->asset.'.png') }}" alt="Postingan" class="mw-100 rounded-top-3 border" style="height: 12rem; object-fit: cover;">
        <div class="card-body">
            <div class="d-flex">
                <div class="w-100">
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <span class="fs-5 fw-semibold">{{ Str::limit($event->title, 50, '...') }}</span>
                            <br>
                            <small class="text-muted">{{date('d M', strtotime($event->start_date))}}  -  {{date('d M', strtotime($event->end_date))}}</small>
                        </div>
                    </div>
                    <a href="{{ route('event-detail', ['id' => $event->id]) }}" class="btn btn-primary w-100">Go to Event</a>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach
</div>

@endsection