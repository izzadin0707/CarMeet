@extends('layouts.main')

@section('content')
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <span class="fs-3 fw-semibold">
            {{ $event->title }}
        </span>
        <br>
        <small class="text-muted">
            Created by {{ $event->user->name }} • {{ date('d F Y', strtotime($event->created_at)) }}
        </small>
    </div>
</div>

<div class="mb-3 shadow-sm border-0">
    <img src="{{ URL::asset('storage/events/'. $event->asset.'.png') }}" alt="Postingan" class="w-100 rounded-3" style="object-fit: cover;">
</div>

<div class="card mb-3 shadow-sm border-0">
  <div class="card-body">
    <div>
        {{ $event->desc }}
    </div>
  </div>
</div>

@endsection