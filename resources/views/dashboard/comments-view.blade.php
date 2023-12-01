@extends('dashboard.layouts.main')

@section('main')
<div class="shadow rounded border">
    <div class="p-3 rounded-3">
        <div class="rounded-3 pb-4">
            <div class="d-flex align-items-center">
                <div>
                    @if ($assets->where('user_id', $comment->user_id)->where('status', 'photo-profile')->count() !== 0)
                        @foreach ($assets as $asset)
                            @if ($asset->status == 'photo-profile' && $asset->user_id == $comment->user_id)
                            <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="" class="rounded-circle border object-fit-cover" style="width: 75px; height: 75px;">
                            @endif
                        @endforeach
                    @else
                    <img src="{{ URL::asset('photo-profile.png') }}" alt="" class="rounded-circle border object-fit-cover" style="width: 75px; height: 75px;">
                    @endif
                </div>
                <a href="{{ route('dashboard-users-view', ['id' => $comment->users->id]) }}" class="fs-3 ms-2 text-decoration-none">{{ $comment->users->username }}</a>
            </div>
            <div class="ms-5">
                <p class="ms-5 text-break">
                    {{ $comment->desc }}
                </p>
            </div>
            <div class="float-end">
                <small class="text-body-secondary">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
    <div class="rounded-bottom" style="background-color: var(--bs-border-color)">
        <div class="py-2 px-2 d-flex justify-content-between">
            <div>
                <a href="{{ route('dashboard-comments-deleted', ['id' => $comment->id]) }}" id="delete-comment" class="btn btn-danger">Deleted</a>
                <a href="{{ route('dashboard-creations-view', ['id' => $comment->creation_id]) }}" class="btn btn-primary">Show Creation</a>
            </div>
            <button class="btn btn-secondary" onclick="history.back()">Back</button>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#delete-comment").click(function(e) {
            e.preventDefault();
    
            var url = $(this).attr("href");
    
            var confirmDelete = confirm("Apakah Anda yakin ingin menghapus komentar ini?");
    
            if (confirmDelete) {
                window.location.href = url;
            }
        });
    });
</script>