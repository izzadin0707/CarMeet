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
            <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from name">
            <button name="btn-search" id="btn-search" class="btn btn-secondary m-2 py-2"><i class="bi bi-search"></i></button>
        </div>
    </div>
    <div class="px-3 py-3" id="table">
        <table class="table" style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created_at</th>
                    <th scope="col">Updated_at</th>
                    <th style="width: 100px;" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->first() != null)
                <?php $i = 1;?>
                @foreach ($users as $user)
                <tr>
                    <th scope='row'>{{ $i }}</th>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($banned->where('user_id', $user->id)->first() != null)
                    <td>Banned</td>
                    @else
                    <td>Unbanned</td>
                    @endif
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td><div class="d-flex"><a href='{{ route('dashboard-users-view', ['id' => $user->id]) }}' class='text-decoration-none bg-primary text-light mx-1 px-2 py-2 rounded'>View</a></div></td>
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
                url: '/dashboard/users-search',
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