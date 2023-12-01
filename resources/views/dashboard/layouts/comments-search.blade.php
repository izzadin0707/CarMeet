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