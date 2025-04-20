@extends('layouts.main')

@section('content')
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <h4 class="card-title mb-0">Report Management</h4>
    </div>
</div>

@if ($reports->isEmpty())
    <div class="text-center mt-5">
        <p class="text-muted">No reports available</p>
    </div>
@else
    @foreach ($reports as $report)
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex">
                    <img src="{{ 
                        $assets->where('user_id', $report->user_id)
                            ->where('status', 'photo-profile')
                            ->first()
                            ? URL::asset('storage/assets/' . $assets->where('user_id', $report->user_id)
                                ->where('status', 'photo-profile')
                                ->first()
                                ->asset . '.png') 
                            : URL::asset('photo-profile.png') 
                    }}" 
                    class="rounded-circle me-3" 
                    style="width: 40px; height: 40px; object-fit: cover;">
                    
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="fw-semibold">{{ $report->user->name }}</span>
                                <small class="text-muted ms-2">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if($report->creation_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('post-detail', ['category' => $report->creation->categorys->slug, 'id' => $report->creation->id]) }}">
                                                <i class="bi bi-eye me-2"></i>View Post
                                            </a>
                                        </li>
                                    @elseif($report->comment_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('post-detail', ['category' => $report->comment->creations->categorys->slug, 'id' => $report->comment->creations->id]) }}">
                                                <i class="bi bi-eye me-2"></i>View Comment
                                            </a>
                                        </li>
                                    @elseif($report->profile_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile', ['username' => urlencode($report->profile->username)]) }}">
                                                <i class="bi bi-eye me-2"></i>View Profile
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger" onclick="openModalDelete('{{ route('delete-report') }}', 'POST', {id: {{ $report->id }}})">
                                            <i class="bi bi-trash me-2"></i>Delete Report
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                @if($report->creation_id)
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Posted by:</strong> {{ $report->creation->users->name }}
                                            <p class="mb-0 mt-2">{{ $report->creation->desc }}</p>
                                        </div>
                                    </div>
                                @elseif($report->comment_id)
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Commented by:</strong> {{ $report->comment->users->name }}
                                            <p class="mb-0 mt-2">{{ $report->comment->desc }}</p>
                                        </div>
                                    </div>
                                @elseif($report->profile_id)
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>Reported User:</strong> {{ $report->profile->name }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div style="margin-bottom: 10rem;"></div>
@endsection