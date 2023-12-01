@extends('dashboard.layouts.main')

@section('main')
<div class="shadow rounded">
    <div class="px-3 py-3">
        <p>From : {{ $report->user->username }}</p>
        <p>Created_at : {{ $report->created_at }}</p>
        <p>Message :</p>
        <p class="fs-2 text-break">{{ $report->desc }}</p>
    </div>
    <div class="rounded-bottom" style="background-color: var(--bs-border-color)">
        <div class="py-2 px-2 d-flex justify-content-between">
            @if ($report->creation_id != null)
            <a href="{{ route('dashboard-creations-view', ['id' => $report->creation_id]) }}" class="btn btn-secondary">Show Creation</a>
            @endif

            @if ($report->comment_id != null)
            <a href="{{ route('dashboard-comments-view', ['id' => $report->comment_id]) }}" class="btn btn-secondary">Show Comment</a>
            @endif

            @if ($report->profile_id != null)
            <a href="{{ route('dashboard-users-view', ['id' => $report->profile_id]) }}" class="btn btn-secondary">Show Profile</a>
            @endif
            <a href="{{ route('dashboard-reports') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection