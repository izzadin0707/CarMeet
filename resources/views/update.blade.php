@extends('layouts.main')

@section('container')
    <div class="container">
        <div>
            {{-- post file --}}
            <div>
                @if (session('status'))
                    <div class="alert alert-danger">
                        <span>{{ session('status') }}</span>
                    </div>
                @endif
                <form action="{{ route('update') }}" enctype="multipart/form-data" method="POST" id="post">
                    @csrf
                    @foreach ($creations as $creation)
                    <div class="container d-flex flex-wrap" style="height: 70vh;">
                        <div class="flex-fill card m-2" style="width: 50%; height: 100%;">
                            <div class="d-flex justify-content-center align-items-center" id="preview" style="height: 100%;">
                                @if ($creation->type_file == 'png')
                                <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" class="card-img-top postImage" alt="..." style="max-height: 60vh; width: auto; max-width: 90%">
                                @elseif ($creation->type_file == 'mp4')
                                <video id="previewVideo" class="postVideo" style="height: auto; max-width: 90%">
                                    <source src="{{ asset('storage/creations/'.$creation->creation.'.'.$creation->type_file.'#t=120') }}" type="video/{{ $creation->type_file }}">
                                    Maaf, browser Anda tidak mendukung pemutaran video.
                                </video>
                                @endif
                            </div>
                        </div>
                        <div class="flex-fill card m-2">
                            <div class="card-body" style="position: relative;">
                                <select class="form-select mb-4" aria-label="Default select example" id="postCategory" name="category" required>
                                    <option disabled value="">Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $creation->category)select @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mb-4" id="exampleFormControlInput1" placeholder="Title" name="title" value="{{ $creation->title }}" required>
                                <textarea class="form-control mb-4" id="exampleFormControlTextarea1" rows="10" placeholder="Description" name="desc">{{ $creation->desc }}</textarea>
                                <button type="submit" class="btn btn-secondary" style="float: right;">Post Now <i class="bi bi-arrow-right-short"></i></button>
                                <a class="btn btn-secondary me-2" style="float: right;" onclick="history.back()"><i class="bi bi-arrow-left-short"></i> Back</a>
                            </div>
                        </div>
                        <input type="hidden" name="creation" value="{{ $creation->id }}">
                    </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
@endsection
