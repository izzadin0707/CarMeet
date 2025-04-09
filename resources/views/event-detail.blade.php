@extends('layouts.main')

@section('content')
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <a href="{{ route('event') }}"><i class="bi bi-arrow-left"></i></a>
            @if (Auth::user()->id == $event->user_id)
            <div class="d-flex gap-2">
                <a href="#" class="btn btn-outline-danger py-1 px-2" onclick="openModalDelete('{{ route('event-delete', $event->id) }}', 'GET')"><i class="bi bi-trash"></i></a>
                <a href="{{ route('event-form', $event->id) }}" class="btn btn-outline-primary py-1 px-2"><i class="bi bi-pencil-square"></i></a>
            </div>
            @endif
        </div>
        <span class="fs-3 fw-semibold">
            {{ $event->title }}
        </span>
        <br>
        <small class="text-muted">
            Event Period : {{ date('d F Y', strtotime($event->start_date)) }} - {{ date('d F Y', strtotime($event->end_date)) }}
        </small>
    </div>
</div>

<div class="mb-3 shadow-sm border-0">
    <img src="{{ URL::asset('storage/events/'. $event->asset.'.png') }}" alt="Postingan" class="w-100 rounded-3" style="object-fit: cover;">
</div>

<div class="card mb-3 shadow-sm border-0">
  <div class="card-body">
    <div>
        {!! $event->desc !!}
    </div>
  </div>
</div>

@endsection