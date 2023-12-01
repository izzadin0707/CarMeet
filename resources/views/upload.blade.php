@extends('layouts.main')

@section('container')
    <div class="container">
        <div>
            {{-- post file --}}
            <div>
                <form action="{{ route('upload') }}" enctype="multipart/form-data" method="POST" id="post">
                    @csrf
                    <div class="container d-flex flex-wrap" style="height: 70vh;">
                        <div class="flex-fill card m-2" style="width: 50%; height: 100%;">
                            <div class="d-flex justify-content-center align-items-center" id="preview" style="height: 100%;">
                                <p>Media Preview</p>
                            </div>
                            <div class="card-body">
                                <input class="form-control" type="file" id="formFile" style="display: none;" name="file" accept="image/*, video/*" required>
                            </div>
                        </div>
                        <div class="flex-fill card m-2">
                            <div class="card-body" style="position: relative;">
                                <select class="form-select mb-4" aria-label="Default select example" id="postCategory" name="category" required>
                                    <option disabled selected value="">Choose Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mb-4" id="exampleFormControlInput1" placeholder="Title" name="title" required>
                                <textarea class="form-control mb-4" id="exampleFormControlTextarea1" rows="10" placeholder="Description" name="desc"></textarea>
                                <button type="submit" class="btn btn-secondary" style="float: right;">Post Now <i class="bi bi-arrow-right-short"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
