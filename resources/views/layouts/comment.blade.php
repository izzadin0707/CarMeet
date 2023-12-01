@if(count($comments) <= 0)
    <div class="text-center mt-4">
        <p class="fs-5 text-body-secondary">no comment</p>
    </div>
@endif
@foreach ($comments as $comment)
<div class="border row mx-2 my-3 rounded">
    <div class="col-12 d-flex justify-content-between" >
        <div class="d-flex">
            @if (count($assets) !==  0)    
                @foreach ($assets as $asset)
                    @if ($assets->where('status', 'photo-profile')->count() != 0)
                        @if ($asset->status == 'photo-profile' && $asset->user_id == $comment->user_id)
                        <a href="{{ url('profile/'.str_replace('#', '%23', $comment->users->username)) }}" class="fw-semibold text-decoration-none" id="home_title"><div class="mt-2"><img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" class="border me-1 rounded-circle object-fit-cover" style="width: 32px; height: 32px;" id="profile_icon" alt="">
                        @endif
                    @else
                    <a href="{{ url('profile/'.str_replace('#', '%23', $comment->users->username)) }}" class="fw-semibold text-decoration-none" id="home_title"><div class="mt-2"><img src="{{ URL::asset('photo-profile.png') }}" class="border me-1 rounded-circle object-fit-cover" style="width: 32px; height: 32px;" id="profile_icon" alt="">
                    @endif
                @endforeach
            @else
            <a href="{{ url('profile/'.str_replace('#', '%23', $comment->users->username)) }}" class="fw-semibold text-decoration-none" id="home_title"><div class="mt-2"><img src="{{ URL::asset('photo-profile.png') }}" class="border me-1 rounded-circle object-fit-cover" style="width: 32px; height: 32px;" id="profile_icon" alt="">    
            @endif
            @if (strlen($comment->users->name) > 10)
                {{ substr($comment->users->name, 0, 10).'...' }}
            @else
                {{ $comment->users->name }}
            @endif
            </div></a>
            <small class="align-self-center mt-1 ms-1 text-body-secondary">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
        <div class="dropdown dropstart" style="margin-right: -13px;">
            <a class="btn" style="border: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical fs-6"></i>
            </a>
            
            <ul class="dropdown-menu">
                @if ($comment->user_id == Auth::id())
                <li><a class="dropdown-item comment-remove" id="comment-remove-{{ $comment->id }}" data-comment-id="{{ $comment->id }}" data-creation-id="{{ $comment->creation_id }}">Remove</a></li>
                @else
                <li><a class="dropdown-item" href="{{ route('report-comment-form', ['comment' => $comment->id]) }}" id="comment-report-{{ $comment->id }}">Report</a></li>
                @endif
            </ul>
            </div>
    </div>
    <div class="col-12 mt-2">
        <div class="mb-1">
            @if (strlen($comment->desc) > 85)
                <p class="text-break" id="sub-text-{{ $comment->id }}" style="display: block;">
                    {{ substr($comment->desc, 0, 85)."..." }}
                    <button class="nav-link border-0 text-primary-emphasis text-decoration-underline btnMore" data-comment-id="{{ $comment->id }}">more</button>
                </p>
                <p class="text-break" id="more-text-{{ $comment->id }}" style="display: none;">
                    {{ $comment->desc }}
                    <button class="nav-link border-0 text-primary-emphasis text-decoration-underline btnLess" data-comment-id="{{ $comment->id }}">less</button>
                </p>
            @else
                <p class="text-break">
                    {{ $comment->desc }}
                </p>
            @endif
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".btnMore").click(function () {
        var comment_id = $(this).data("comment-id");
        $("#sub-text-"+comment_id).css('display', 'none'); 
        $("#more-text-"+comment_id).css('display', 'block'); 
    });

    $(".btnLess").click(function () {
        var comment_id = $(this).data("comment-id");
        $("#sub-text-"+comment_id).css('display', 'block'); 
        $("#more-text-"+comment_id).css('display', 'none'); 
    });
});

function showComment(creation_id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/show-comment',
        type: 'POST',
        data: {
            creation_id: creation_id,
            _token: csrfToken
        },
        success: function(response) {
            $('#comment-bar').html(response);
        }
    });
}

function commentRemove(comment_id, creation_id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    $.ajax({
        type: 'POST',
        url: '/remove-comment', // Ganti dengan URL Anda
        data: {
            comment_id: comment_id,
            _token: csrfToken
        },
        success: function(data) {                
            if (data == true) {
                showComment(creation_id);
            } else {
                alert("Failed to remove comment.");
            }
            $(".loading").toggleClass("show");
            $(".loading i").toggleClass("show");
        }
    });
}

$(document).ready(function () {
    $(".comment-remove").click(function () {
        var message = "Do you want to remove this comment?";
        if(confirm(message)){
            $(".loading").toggleClass("show");
            $(".loading i").toggleClass("show");
            var comment_id = $(this).data("comment-id");
            var creation_id = $(this).data("creation-id");
            commentRemove(comment_id, creation_id);
        }
    });
});
</script>