@extends('dashboard.layouts.main')

@section('main')
<div class="shadow rounded border">
    <div class="px-3 pb-3 pt-1">
        <div class="conteiner w-100 mb-4">
            @if (count($assets) !==  0)    
                @foreach ($assets as $asset)
                    @if ($assets->where('status', 'banner')->count() !== 0)
                        @if ($asset->status == 'banner')
                        <div class="row rounded-4 border" style="background-image: url('{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}'); height: 20rem; background-size: cover; background-position: center;"></div>    
                        @endif
                    @else
                    <div class="row rounded-4 border" style="background-color: grey; height: 20rem; background-size: cover; background-position: center;"></div>
                    @endif
                @endforeach
            @else
                <div class="row rounded-4 border" style="background-color: grey; height: 20rem; background-size: cover; background-position: center;"></div>
            @endif
        </div>
        <div class="row">
            <div class="col-3 border-end text-center">
                @if (count($assets) !==  0)    
                    @foreach ($assets as $asset)
                        @if ($assets->where('status', 'photo-profile')->count() != 0)
                            @if ($asset->status == 'photo-profile')
                            <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">    
                            @endif
                        @else
                        <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                        @endif
                    @endforeach
                @else
                    <img src="{{ URL::asset('photo-profile.png') }}" alt="Photo Profile" class="rounded-circle border object-fit-cover" style="width: 200px; height: 200px;">                    
                @endif
            </div>
            <div class="col-9 ps-4">
                <p class="fs-5">Name : {{ $user->name }}</p>
                <p class="fs-5">Username : {{ $user->username }}</p>
                <p class="fs-5">Email : {{ $user->email }}</p>
                <p class="fs-5">Posts : {{ $posts }}</p>
                <p class="fs-5">Created_at : {{ $user->created_at }}</p>
            </div>
        </div>
    </div>
    <div class="rounded-bottom" style="background-color: var(--bs-border-color)">
        <div class="py-2 px-2 d-flex justify-content-between">
            <div class="d-flex">
            @if ($banned != null)
            <?php
                $banDate = $banned->banned;
                $today = time();
                if(strtotime($banDate) <= $today){
                    $banned->delete();
                    $days = null;
                }else{
                    $diff = strtotime($banned->banned) - time();
                    $days = ceil($diff / (60 * 60 * 24));
                }
            ?>
                @if ($days != null)
                <a href="{{ route('dashboard-users-unbanned', ['id' => $banned->id]) }}" class="btn btn-danger">Unbanned, {{ $days }} days left.</a>
                @else
                <a href="{{ route('dashboard-users-banned', ['id' => $user->id]) }}" class="btn btn-danger">Banned</a>
                @endif
            @else    
            <a href="{{ route('dashboard-users-banned', ['id' => $user->id]) }}" class="btn btn-danger">Banned</a>
            @endif
            @if ($user->id !== Auth::guard('admin')->user()->id)
            <form action="{{ route('change-role') }}" method="POST" class="d-flex">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="ms-2">
                    <button type="submit" class="btn btn-primary">Change Role</button>
                </div>
                <div class="ms-2">
                    <select class="form-select" name="roles" aria-label="Default select example">
                        @if ($user->roles == 1)
                        <option value="1" selected>Admin</option>
                        <option value="0">User</option>
                        @else
                        <option value="1">Admin</option>
                        <option value="0" selected>User</option>
                        @endif
                    </select>
                </div>
            </form>
            @endif
            </div>
            <button class="btn btn-secondary" onclick="history.back()">Back</button>
        </div>
    </div>
</div>
@endsection