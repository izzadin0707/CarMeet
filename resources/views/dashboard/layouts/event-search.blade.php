<table class="table" style="font-size: 12px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Created_at</th>
            <th scope="col">Updated_at</th>
            <th style="width: 100px;" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($event->first() != null)
        <?php $i = 1;?>
        @foreach ($event as $e)
        <tr>
            <th scope='row'>{{ $i }}</th>
            <td>{{ $e->user->username }}</td>
            <td>{{ $e->title }}</td>
            <td>
                @if (strlen($e->desc) > 35)
                    {{ substr($e->desc, 0, 35) }}...
                @else
                    {{ $e->desc }}
                @endif
            </td>
            <td>{{ date('Y M d', strtotime($e->start_date)) }}</td>
            <td>{{ date('Y M d', strtotime($e->end_date)) }}</td>
            <td>{{ $e->created_at }}</td>
            <td>{{ $e->updated_at }}</td>
            <td>
                <div class="d-flex">
                    <a href='{{ route('dashboard-event-view', ['id' => $e->id]) }}' class='text-decoration-none bg-primary text-light mx-1 px-2 py-2 rounded'>View</a>
                    <a class='text-decoration-none bg-danger text-light mx-1 px-2 py-2 rounded'>Delete</a>
                </div>
            </td>
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