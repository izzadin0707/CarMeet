@extends('dashboard.layouts.main')

@section('main')
<form action="{{ isset($event) ? route('dashboard-event-update') : route('dashboard-event-upload') }}" enctype="multipart/form-data" method="POST" class="w-100">
    <div class="shadow rounded border">
        @csrf
        @if (isset($event))
            <input type="hidden" name="id" value="{{ isset($event) ? $event->id : '' }}">
        @endif
        <div class="px-3 pb-3 pt-1">
            <div class="row">
                {{-- Form Title and Dates --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="@ex: Car Event" value="{{ isset($event) ? $event->title : '' }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ isset($event) ? date('Y-m-d', strtotime($event->start_date)) : '' }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ isset($event) ? date('Y-m-d', strtotime($event->end_date)) : '' }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Description --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="desc" class="form-control" style="resize: none; height: 7.2rem;" placeholder="@ex: Car Event">{{ isset($event) ? $event->desc : '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Banner Preview Section --}}
            <div class="container w-100 mb-4 px-2" id="banner-preview">
                @if (isset($event))
                    <div class="row rounded-2 border" style="background-image: url('{{ URL::asset('storage/events/'.$event->asset.'.png') }}'); height: 20rem; background-size: cover; background-position: center;"></div>    
                @else
                    <div class="row rounded-2 border" style="background-color: grey; height: 20rem; background-size: cover; background-position: center;"></div>
                @endif
            </div>

            {{-- File Input for Image --}}
            <div class="mb-3">
                <input type="file" id="formFile" name="file" class="form-control" accept="image/*" {{ isset($event) ? '' : 'required' }}>
            </div>
        </div>

        {{-- Save/Back Buttons --}}
        <div class="rounded-bottom" style="background-color: var(--bs-border-color)">
            <div class="py-2 px-2 d-flex justify-content-end">
                <button type="button" class="btn btn-danger me-2" onclick="history.back()">Back</button>
                <button type="submit" class="btn btn-secondary">Save</button>                
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // Banner preview on file change
    $('#formFile').change(function() {
        var input = this;
        var url = window.URL || window.webkitURL;
        var file = input.files[0];
        var fileURL = url.createObjectURL(file);

        if (file.type.startsWith('image/')) {
            $('#banner-preview').html(`
                <div class="row rounded-2 border" style="background-image: url('${fileURL}'); height: 20rem; background-size: cover; background-position: center;"></div>
            `);
        }
    });
});
</script>
@endsection
