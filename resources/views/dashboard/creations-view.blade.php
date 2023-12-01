@extends('dashboard.layouts.main')

@section('main')
<div class="shadow rounded border">
    <div class="border p-3 rounded-3" id="reportCreation">
        <div class="d-flex">
            @if ($creation->type_file == 'png')
            <img class="w-50 rounded-start object-fit-cover reportImage" src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="">
            @elseif ($creation->type_file == 'mp4')
            <video id="previewVideo" class="w-50 rounded-start object-fit-cover reportVideo">
                <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                Maaf, browser Anda tidak mendukung pemutaran video.
            </video>
            @endif
            <div class="w-50 px-3 d-flex flex-column">
                <div class="p-2 fs-3">{{ $creation->title }}</div>
                <div class="p-2 overflow-y-auto text-break mb-2" style="max-height: 190px;">
                    {{ $creation->desc }}
                </div>
                <div class="mt-auto p-2"><small class="text-body-secondary">{{ $creation->created_at->diffForHumans() }}, creator : <a href="{{ route('dashboard-users-view', ['id' => $creation->users->id]) }}" class="text-decoration-none" style="color: var(--bs-body);">{{ $creation->users->name }}</a></small></div>
            </div>
        </div>
    </div>
    <div class="rounded-bottom" style="background-color: var(--bs-border-color)">
        <div class="py-2 px-2 d-flex justify-content-between">
            <a href="{{ route('dashboard-creations-deleted', ['id' => $creation->id]) }}" id="delete-comment" class="btn btn-danger">Deleted</a>
            <button class="btn btn-secondary" onclick="history.back()">Back</button>
        </div>
    </div>
</div>
@endsection

<style>
.reportImage {
    transition: 0.3s;
}

.reportImage:hover {
    opacity: 0.7;
}

.reportVideo {
    transition: 0.3s;
}

.reportVideo:hover {
    opacity: 0.7;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".reportImage").click(function () {
        var width = $(window).width();
        var src = $(this).attr("src");
        $("html").toggleClass("show");
        $("#fullImg").attr("src", src);
        $(".modalImg").toggleClass("show");
    });
});

$(document).ready(function () {
    $(".reportVideo").click(function () {
        var width = $(window).width();
        var src = $("source", this).attr("src");
        $("html").toggleClass("show");
        $("#fullVideo").attr("src", src);
        $(".modalVideo").toggleClass("show");
    });
});

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