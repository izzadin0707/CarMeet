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
            <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from title and desc">
            <button type="submit" name="btn-search" class="btn btn-secondary m-2"><i class="bi bi-search"></i></button>
        </div>
    </div>
    <div class="px-3 py-3" id="table">
        <table class="table" style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Title</th>
                    <th scope="col">Desc</th>
                    <th scope="col">Creation</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Updated_at</th>
                    <th style="width: 100px;" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($creations->first() != null)
                <?php $i = 1?>
                @foreach ($creations as $creation)
                <tr>
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $creation->users->username }}</td>
                    <td>{{ $creation->title }}</td>
                    <td>
                        @if (strlen($creation->desc) > 35)
                            {{ substr($creation->desc, 0, 35) }}...
                        @else
                            {{ $creation->desc }}
                        @endif
                    </td>
                    <td>{{ $creation->creation }}</td> 
                    <td>{{ $creation->created_at }}</td>
                    <td>{{ $creation->updated_at }}</td>
                    <td><div class="d-flex"><a href="{{ route('dashboard-creations-view', ['id' => $creation->id]) }}" class="text-decoration-none bg-primary text-light mx-1 px-2 py-2 rounded">View</a></div></td>
                </tr>
                <?php $i++?>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">null</td>
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
                url: '/dashboard/creations-search',
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