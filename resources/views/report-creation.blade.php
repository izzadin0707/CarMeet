@extends('layouts.main')

@section('container')
    <div class="container">
        @if (session('message'))
        <input type="hidden" value="{{ session('message') }}" id="message">
        @else
        <input type="hidden" value="" id="message">
        @endif
        {{-- Report Creation --}}
        <div class="border p-4 rounded-3 pb-5" id="reportCreation">
            <div class="d-flex">
                @if ($creation->type_file == 'png')
                <img class="w-50 rounded-start object-fit-cover reportImage" src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="">
                @elseif ($creation->type_file == 'mp4')
                <video id="previewVideo" class="w-50 rounded-start object-fit-cover reportVideo">
                    <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                    Maaf, browser Anda tidak mendukung pemutaran video.
                </video>
                @endif
                <div class="w-50 rounded-end border p-3 d-flex flex-column">
                    <div class="p-2 fs-3">{{ $creation->title }}</div>
                    <div class="p-2 overflow-y-auto text-break mb-2" style="max-height: 190px;">
                        {{ $creation->desc }}
                    </div>
                    <div class="mt-auto p-2"><small class="text-body-secondary">{{ $creation->created_at->diffForHumans() }}, creator : <a href="{{ url('profile/'.str_replace('#', '%23', $creation->users->username)) }}" class="text-decoration-none" style="color: var(--bs-body);">{{ $creation->users->name }}</a></small></div>
                </div>
            </div>
            <form action="{{ route('report.creation') }}" enctype="multipart/form-data" method="POST" id="post" class="mt-3">
                @csrf
                <textarea class="form-control" name="report_message" cols="30" rows="5" placeholder="Message" required></textarea>
                <input type="hidden" name="creation_id" value="{{ $creation->id }}">
                <button type="submit" class="btn btn-secondary float-end my-2">Send</button>
            </form>
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

$(document).ready(function () {
    if($('#message').val() != ''){
        alert($('#message').val());
    }
});
</script>
