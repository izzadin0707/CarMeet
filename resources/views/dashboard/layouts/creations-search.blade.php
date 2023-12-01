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