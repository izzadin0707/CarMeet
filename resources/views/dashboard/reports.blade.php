@extends('dashboard.layouts.main')

@section('main')
@if (session('message'))
    <div class="alert alert-danger">
        <span>{{ session('message') }}</span>
    </div>
@endif
<select class="form-select" id="type" aria-label="Default select example">
    <option value="0" selected>All</option>
    <option value="1">Creations</option>
    <option value="2">Comments</option>
    <option value="3">Profile</option>
</select>
{{-- ALL --}}
<div id="all" style="display: block;">
    <p class="fs-3 mt-3">Unread</p>
    <div class="shadow rounded">
        <div class="rounded-top p-4" style="background-color: var(--bs-border-color)"></div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 0)->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 0) as $report)
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
                    <?php $i++;?>
                    @endforeach

                    @else
                    <tr>
                        <td colspan="6" class="text-center">null</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <p class="fs-3 mt-3">Read</p>
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
        </div>
    </div>
</div>
{{-- CREATION --}}
<div id="creation" style="display: none;">
    <p class="fs-3 mt-3">Unread</p>
    <div class="shadow rounded">
        <div class="rounded-top p-4" style="background-color: var(--bs-border-color)"></div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 0)->whereNotNull('creation_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 0)->whereNotNull('creation_id') as $report)
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
        </div>
    </div>
    <p class="fs-3 mt-3">Read</p>
    <div class="shadow rounded">
        <div class="rounded-top" style="background-color: var(--bs-border-color)">
            <div class="py-1 px-2 d-flex align-items-center">
                <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from desc">
                <button type="submit" name="btn-search" class="btn btn-secondary m-2"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 1)->whereNotNull('creation_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 1)->whereNotNull('creation_id') as $report)
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
        </div>
    </div>
</div>
{{-- COMMENT --}}
<div id="comment" style="display: none;">
    <p class="fs-3 mt-3">Unread</p>
    <div class="shadow rounded">
        <div class="rounded-top p-4" style="background-color: var(--bs-border-color)"></div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 0)->whereNotNull('comment_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 0)->whereNotNull('comment_id') as $report)
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
        </div>
    </div>
    <p class="fs-3 mt-3">Read</p>
    <div class="shadow rounded">
        <div class="rounded-top" style="background-color: var(--bs-border-color)">
            <div class="py-1 px-2 d-flex align-items-center">
                <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from desc">
                <button type="submit" name="btn-search" class="btn btn-secondary m-2"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 1)->whereNotNull('comment_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 1)->whereNotNull('comment_id') as $report)
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
        </div>
    </div>
</div>
{{-- PROFILE --}}
<div id="profile" style="display: none;">
    <p class="fs-3 mt-3">Unread</p>
    <div class="shadow rounded">
        <div class="rounded-top p-4" style="background-color: var(--bs-border-color)"></div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 0)->whereNotNull('profile_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 0)->whereNotNull('profile_id') as $report)
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
        </div>
    </div>
    <p class="fs-3 mt-3">Read</p>
    <div class="shadow rounded">
        <div class="rounded-top" style="background-color: var(--bs-border-color)">
            <div class="py-1 px-2 d-flex align-items-center">
                <input type="text" name="search" id="search" class="form-control w-25" placeholder="search from desc">
                <button type="submit" name="btn-search" class="btn btn-secondary m-2"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="px-3 py-3">
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
                    @if ($reports->where('read', 1)->whereNotNull('profile_id')->first() != null)
                    <?php $i = 1?>
                    @foreach ($reports->where('read', 1)->whereNotNull('profile_id') as $report)
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
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#type').on('change' ,function() {
        if(this.value == 0){
            $('#all').css('display', 'block');
            $('#creation').css('display', 'none');
            $('#comment').css('display', 'none');
            $('#profile').css('display', 'none');
        }else if(this.value == 1){
            $('#creation').css('display', 'block');
            $('#all').css('display', 'none');
            $('#comment').css('display', 'none');
            $('#profile').css('display', 'none');
        }else if(this.value == 2){
            $('#comment').css('display', 'block');
            $('#all').css('display', 'none');
            $('#creation').css('display', 'none');
            $('#profile').css('display', 'none');
        }else if(this.value == 3){
            $('#profile').css('display', 'block');
            $('#all').css('display', 'none');
            $('#creation').css('display', 'none');
            $('#comment').css('display', 'none');
        }
    });
});

$(document).ready(function () {
    function show(search) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/dashboard/reports-search',
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
        $("#type").val("0");
        $('#all').css('display', 'block');
        $('#creation').css('display', 'none');
        $('#comment').css('display', 'none');
        $('#profile').css('display', 'none');
        $('#table').html('<p class="text-center fs-5 fw-semibold">Loading...</p>');
        show($(this).val());
    });
});
</script>