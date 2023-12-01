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