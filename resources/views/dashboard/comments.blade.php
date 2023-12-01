@extends('dashboard.layouts.main')

@section('main')
@if (session('message'))
    <div class="alert alert-danger">
        <span>{{ session('message') }}</span>
    </div>
@endif
<div class="shadow rounded">
    <div class="rounded-top" style="background-color: var(--bs-border-color)">
        <div class="py-1 px-2 d-flex align-items-center">
            <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from desc">
            <button type="submit" name="btn-search" class="btn btn-secondary m-2"><i class="bi bi-search"></i></button>
        </div>
    </div>
    <div class="px-3 py-3" id="table">
        <table class="table" style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Creation_id</th>
                    <th scope="col">User</th>
                    <th scope="col">Desc</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Updated_at</th>
                    <th style="width: 100px;" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($comments->first() != null)
                <?php $i = 1?>
                @foreach ($comments as $comment)    
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $comment->creation_id }}</td>
                    <td>{{ $comment->users->username }}</td>
                    <td>
                        @if (strlen($comment->desc) > 35)
                            {{ substr($comment->desc, 0, 35) }}...
                        @else
                            {{ $comment->desc }}
                        @endif
                    </td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->updated_at }}</td>
                    <td><div class="d-flex"><a href="{{ route('dashboard-comments-view', ['id' => $comment->id]) }}" class="text-decoration-none bg-primary text-light mx-1 px-2 py-2 rounded">View</a></div></td>
                </tr>
                <?php $i++?>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center">null</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function show(search) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/dashboard/comments-search',
                type: 'POST',
                data: {
                    key: search,
                    _token: csrfToken
                },
                success: function(response) {
                    $('#table').html(response);
                }
            });
        }

        $('#search').keyup(function () {
            $('#table').html('<p class="text-center fs-5 fw-semibold">Loading...</p>');
            show($(this).val());
        });
    });
</script>