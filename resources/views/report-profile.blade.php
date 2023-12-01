@extends('layouts.main')

@section('container')
    <div class="container">
        @if (session('message'))
        <input type="hidden" value="{{ session('message') }}" id="message">
        @else
        <input type="hidden" value="" id="message">
        @endif
        {{-- Report Profile --}}
        <div class="border p-4 rounded-3 pb-5" id="reportCreation">
            <div class="conteiner w-100 mb-4">
                @if (count($assets) !==  0)    
                    @foreach ($assets as $asset)
                        @if ($assets->where('status', 'banner')->count() !== 0)
                            @if ($asset->status == 'banner' && $asset->user_id == $user->id)
                            <div class="row rounded-4 border" style="background-image: url('{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}'); height: 20rem; background-size: cover; background-position: center;"></div>    
                            @endif
                        @else
                        <div class="row rounded-4 border" style="background-color: grey; height: 20rem; background-size: cover; background-position: center;"></div>
                        @endif
                    @endforeach
                @else
                    <div class="row rounded-4 border" style="background-color: grey; height: 20rem; background-size: cover; background-position: center;"></div>
                @endif
            </div>
            <div class="row" style="margin-top: -125px">
                <div class="col-12 text-center">
                    @if (count($assets) !==  0)    
                        @foreach ($assets as $asset)
                            @if ($assets->where('status', 'photo-profile')->count() != 0)
                                @if ($asset->status == 'photo-profile' && $asset->user_id == $user->id)
                                <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">    
                                @endif
                            @else
                            <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                            @endif
                        @endforeach
                    @else
                        <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                    @endif
                </div>
                <div class="col-12 ps-4 text-center">
                    <p class="fs-1" style="margin-bottom: -15px;">{{ $user->name }}</p>
                    <p class="fs-6 text-secondary">{{ $user->username }}</p>
                </div>
            </div>
            <form action="{{ route('report.profile') }}" enctype="multipart/form-data" method="POST" id="post" class="mt-3">
                @csrf
                <textarea class="form-control" name="report_message" cols="30" rows="5" placeholder="Message" required></textarea>
                <input type="hidden" name="profile_id" value="{{ $user->id }}">
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
