@extends('layouts.main')

@section('container')
    <div class="container">
        <div>
            {{-- remove post --}}
            <form action="{{ route('delete') }}" enctype="multipart/form-data" method="POST" id="post">
                @csrf
                <div class="container" style="height: 70vh;">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <span>{{ $error }}</span>
                </div>
                @endforeach
                @endif
                @foreach ($creations as $creation)
                    <div class="alert alert-danger d-flex justify-content-between">
                        <p>Do you want to remove the post?</p>
                        <div>
                            <button type="submit" class="btn btn-outline">
                                Remove
                            </button>
                            <a href="{{ url('/post/'.$creation->creation) }}" class="btn btn-outline">Cancel</a>
                        </div>
                    </div>
                    <input type="hidden" name="creation" value="{{ $creation->id }}">
                    @endforeach
                </div>
            </form>
        </div>
    </div>
@endsection
