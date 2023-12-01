<table class="table" style="font-size: 12px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col" class="w-25">Desc</th>
            <th scope="col">Type</th>
            <th scope="col">Created_at</th>
            <th scope="col">Updated_at</th>
            <th style="width: 100px;" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($reports->where('read', 1)->first() != null)
        <?php $i = 1?>
        @foreach ($reports->where('read', 1) as $report)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $report->user->username }}</td>
            <td>
                @if (strlen($report->desc) > 50)
                    {{ substr($report->desc, 0, 50) }} ...
                @else
                    {{ $report->desc }}
                @endif
            </td>
            <td>
                @if ($report->creation_id != null)
                    Creation
                @endif

                @if ($report->comment_id != null)
                    Comment
                @endif

                @if ($report->profile_id != null)
                    Profile
                @endif
            </td>
            <td>{{ $report->created_at }}</td>
            <td>{{ $report->updated_at }}</td>
            <td><div class="d-flex"><a href="{{ route('dashboard-report-read', ['id' => $report->id])}}" class="text-decoration-none bg-primary text-light mx-1 px-2 py-2 rounded">Read</a><a href="{{ route('dashboard-report-drop', ['id' => $report->id])}}" class="text-decoration-none bg-danger text-light mx-1 px-2 py-2 rounded">Drop</a></div></td>
        </tr>
        <?php $i++?>
        @endforeach

        @else
        <tr>
            <td colspan="6" class="text-center">null</td>
        </tr>
        @endif
    </tbody>
</table>