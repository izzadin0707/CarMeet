@extends('layouts.main')

@section('content')
<form id="postForm" action="{{ isset($event) ? route('event-update') : route('event-upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($event))
        <input type="hidden" name="id" value="{{ $event->id }}">
    @endif
    <div class="card rounded-3 mb-3 shadow-sm border-0">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ isset($event) ? route('event-detail',  ['id' => $event->id]) : route('event') }}"><i class="bi bi-arrow-left"></i></a>
            </div>
            <div class="mb-3">
                <input type="text" name="title" class="form-control fs-3 fw-semibold" placeholder="Event Title" value="{{ isset($event) ? $event->title : '' }}" required>
            </div>
            <div class="d-flex flex-column flex-xl-row justify-content-between align-items-center gap-3">
                <div class="w-100">
                    <label for="start_date" class="form-label text-muted" style="font-size: .9rem;">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ isset($event) ? date('Y-m-d', strtotime($event->start_date)) : date('Y-m-d') }}" required>
                </div>
                <div class="d-none d-xl-block">
                    <br>
                    <i class="bi bi-dash-lg"></i>
                </div>
                <div class="w-100">
                    <label for="end_date" class="form-label text-muted" style="font-size: .9rem;">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ isset($event) ? date('Y-m-d', strtotime($event->end_date)) : date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-3 rounded-3 shadow-sm border-0">
        <input type="file" name="file" id="mediaFileInput" accept="image/*" style="display:none;" />
        
        @if (!isset($event))
        <button type="button" id="mediaButton" class="btn btn-outline-secondary w-100 fs-1" style="height: 6rem;">
            <i class="bi bi-image"></i>
        </button>
        @endif
    
        <div id="previewContainer" style="{{ isset($event) ? '' : 'display: none;' }}">
            <div id="mediaPreview">
                <div class="position-relative">
                    <div class="position-absolute end-0 m-1">
                        @if (isset($event))
                        <button type="button" id="mediaButton" class="btn btn-sm btn-light rounded-3 opacity-75">
                            <i class="bi bi-image"></i>
                        </button>
                        @endif
                        <button type="button" id="removePreview" class="btn btn-sm btn-light rounded-3 opacity-75" style="{{ isset($event) ? 'display: none;' : '' }}">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <img id="imagePreview" class="rounded-3 w-100" data-old="{{ isset($event) ? URL::asset('storage/events/'. $event->asset.'.png') : '' }}"  src="{{ isset($event) ? URL::asset('storage/events/'. $event->asset.'.png') : '' }}" style="{{ isset($event) ? '' : 'display: none;' }}" />
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-3 rounded-3 shadow-sm border-0">
      <div class="card-body p-0">
        {{-- <textarea id="editor" name="desc" class="w-100 rounded-bottom-3 rounded-top-0 form-control" rows="10" placeholder="Tuliskan isi pikiranmu..."></textarea> --}}
        <div id="editor" class="rounded-bottom-3">
            {!! isset($event) ? $event->desc : '' !!}
        </div>
        <input type="hidden" name="desc" id="desc" value="{{ isset($event) ? $event->desc : '' }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 fs-6 mb-3 pt-1 pb-2">
        {{ empty($isset) ? 'Update you event' : 'Create you event' }} <i class="bi bi-arrow-right ms-2"></i>
    </button>
</form>

<style>
    #editor:focus {
        box-shadow: none !important;
    }

    .ql-toolbar {
        border-radius: 0.5rem 0.5rem 0 0;
    }
</style>

<script>
const quill = new Quill('#editor', {
    placeholder: 'Your Content!',
    theme: 'snow'
});

quill.on('text-change', function(delta, oldDelta, source) {
    document.querySelector("input[name='desc']").value = quill.root.innerHTML;
});

$(document).ready(function() {

    // Media button click handler
    $('#mediaButton').on('click', function() {
        $('#mediaFileInput').click();
    });

    // File input change handler
    $('#mediaFileInput').on('change', function() {
        $('#imagePreview').hide();
        $('#previewContainer').hide();

        var file = this.files[0];
        if (file) {
            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('#previewContainer').show();
                    $('#mediaButton').hide();
                    if ('{{ isset($event) }}' == '1') {
                        $('#removePreview').show();
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    });

    // Remove preview handler
    $('#removePreview').on('click', function() {
        $('#mediaFileInput').val('');
        $('#mediaButton').show();
        
        if ('{{ isset($event) }}' != '1') {
            $('#previewContainer').hide();
            $('#imagePreview').hide();
        } else {
            $('#imagePreview').attr('src', $('#imagePreview').data('old'));
            $('#removePreview').hide();
        }
    });
});
</script>

@endsection