@extends('layouts.main')

@section('container')
    <div class="container">
        @if (session('message'))
        <input type="hidden" value="{{ session('message') }}" id="message">
        @else
        <input type="hidden" value="" id="message">
        @endif
        {{-- Report Comment --}}
        <div class="border p-4 rounded-3 pb-5" id="reportCreation">
            <div class="border rounded-3 px-4 pt-3 pb-5">
                <div class="d-flex align-items-center">
                    <div>
                        @if (count($assets) !==  0)    
                            @foreach ($assets as $asset)
                                @if ($assets->where('status', 'photo-profile')->count() != 0)
                                    @if ($asset->status == 'photo-profile' && $asset->user_id == $comment->user_id)
                                    <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="" class="rounded-circle object-fit-cover" style="width: 75px; height: 75;">
                                    @endif
                                @else
                                <img src="{{ URL::asset('photo-profile.png') }}" alt="" class="rounded-circle object-fit-cover" style="width: 75px; height: 75;">
                                @endif
                            @endforeach
                        @else
                        <img src="{{ URL::asset('photo-profile.png') }}" alt="" class="rounded-circle object-fit-cover" style="width: 75px; height: 75;">
                        @endif
                    </div>
                    <div class="fs-3 ms-2">{{ $comment->users->name }}</div>
                </div>
                <div class="ms-5">
                    <p class="ms-4 text-break">
                        {{ $comment->desc }}
                    </p>
                </div>
                <div class="float-end">
                    <small class="text-body-secondary">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>
            <form action="{{ route('report.comment') }}" enctype="multipart/form-data" method="POST" id="post" class="mt-3">
                @csrf
                <textarea class="form-control" name="report_message" cols="30" rows="5" placeholder="Message" required></textarea>
                <input type="hidden" name="creation_id" value="{{ $comment->creation_id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
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
