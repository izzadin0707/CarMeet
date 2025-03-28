@extends('layouts.main')

@section('content')
{{-- Posting Cepat --}}
<div class="card mb-3">
  <div class="card-body">
    <form id="postForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="d-flex align-items-center mb-3">
          <img src="{{ 
              $auth_assets->where('status', 'photo-profile')->first()
                  ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                  : URL::asset('photo-profile.png') }}" 
              class="rounded-circle me-3" 
              style="width: 40px; height: 40px; object-fit: cover;">
          <textarea name="desc" class="form-control" placeholder="Apa yang ingin Anda bagikan?" rows="3"></textarea>
      </div>
      <div class="d-flex justify-content-between align-items-center">
          <div>
              <!-- Hidden file inputs -->
              <input type="file" name="file" id="imageFileInput" accept="image/*" style="display:none;" />
              {{-- <input type="file" name="file" id="videoFileInput" accept="video/*" style="display:none;" /> --}}
              
              <!-- Buttons to trigger file selection -->
              <button type="button" id="imageButton" class="btn btn-outline-secondary me-2">
                  <i class="bi bi-image"></i>
              </button>
              {{-- <button type="button" id="videoButton" class="btn btn-outline-secondary">
                  <i class="bi bi-camera-video"></i>
              </button> --}}
          </div>
          <button type="submit" class="btn btn-primary">Posting</button>
      </div>

      <!-- Preview Container -->
      <div id="previewContainer" class="mt-3" style="display:none;">
          <div class="d-flex align-items-center">
              <button type="button" id="removePreview" class="btn btn-sm btn-outline-danger me-2">
                  <i class="bi bi-x"></i>
              </button>
              <span id="fileNameDisplay" class="me-2"></span>
          </div>
          <div id="mediaPreview" class="mt-2">
              <img id="imagePreview" style="max-width: 100%; max-height: 300px; display:none;" />
              <video id="videoPreview" controls style="max-width: 100%; max-height: 300px; display:none;"></video>
          </div>
      </div>
    </form>
  </div>
</div>

{{-- Stories/Highlights --}}
{{-- <div class="mb-3 d-flex overflow-auto pb-2">
  <div class="me-3 text-center">
      <img src="{{ asset('default-profile.png') }}" 
           class="rounded-circle mb-1" 
           style="width: 60px; height: 60px; object-fit: cover; border: 2px solid orange;">
      <small class="d-block">username1</small>
  </div>
  <div class="me-3 text-center">
      <img src="{{ asset('default-profile.png') }}" 
           class="rounded-circle mb-1" 
           style="width: 60px; height: 60px; object-fit: cover; border: 2px solid orange;">
      <small class="d-block">username2</small>
  </div>
  <div class="me-3 text-center">
      <div class="rounded-circle mb-1 bg-light d-flex justify-content-center align-items-center" 
           style="width: 60px; height: 60px; border: 2px dashed gray;">
          <i class="bi bi-plus text-muted"></i>
      </div>
      <small class="d-block">Tambah</small>
  </div>
</div> --}}

{{-- Feed Postingan --}}

@if (count($creations) <= 0)
  <p class="fs-4 text-center">no content available</p>
@endif
@foreach ($creations as $creation)

<div class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
          <img src="{{ 
                $auth_assets->where('status', 'photo-profile')->first()
                    ? URL::asset('storage/assets/' . $assets->where('user_id', '-', $creation->user_id)->where('status', 'photo-profile')->first()->asset . '.png') 
                    : URL::asset('photo-profile.png') }}" 
               class="rounded-circle me-3" 
               style="width: 40px; height: 40px; object-fit: cover;">
          <div>
              <h6 class="mb-0">{{ $creation->users->name }}</h6>
              <small class="text-muted">{{ $creation->created_at->diffForHumans() }}</small>
          </div>
      </div>
      <div class="dropdown">
          <button class="btn btn-link" type="button" data-bs-toggle="dropdown">
              <i class="bi bi-three-dots-vertical"></i>
          </button>
          <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Bagikan</a></li>
              <li><a class="dropdown-item" href="#">Simpan</a></li>
              <li><a class="dropdown-item" href="#">Laporkan</a></li>
          </ul>
      </div>
  </div>
  <img src="{{ URL::asset('storage/creations/'.$creation->creation.'.'.$creation->type_file) }}" alt="Postingan">
  <div class="card-body">
      <div class="d-flex justify-content-between mb-2">
          <div>
              <button 
                class="btn btn-link btn-like p-0 text-decoration-none text-danger me-2"
                data-user-id="{{ $user->id }}" 
                data-creation-id="{{ $creation->id }}" 
                data-creation-user-id="{{ $creation->users->id }}">
                  <i class="bi {{ $likes->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                  <span class="like-counts">{{ count($likes->where('creation_id', $creation->id)) }}</span>
              </button>
              <button class="btn btn-link p-0 text-decoration-none text-muted">
                  <i class="bi bi-chat"></i> 0
              </button>
          </div>
          <button 
            class="btn btn-link btn-save p-0 text-decoration-none text-muted"
            data-user-id="{{ $user->id }}" 
            data-creation-id="{{ $creation->id }}">
              <i class="bi {{ $saves->where('user_id', $user->id)->where('creation_id', $creation->id)->first() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
          </button>
      </div>
      <p class="card-text">{{ $creation->desc }}</p>
  </div>
</div>

@endforeach

<script>
  $(document).ready(function() {
      // Image button click handler
      $('#imageButton').on('click', function() {
          $('#imageFileInput').click();
      });

      // Video button click handler
      $('#videoButton').on('click', function() {
          $('#videoFileInput').click();
      });

      // File input change handlers
      $('#imageFileInput, #videoFileInput').on('change', function() {
          // Reset previous preview
          $('#imagePreview, #videoPreview').hide();
          $('#previewContainer').hide();

          var file = this.files[0];
          if (file) {
              var fileName = file.name;
              $('#fileNameDisplay').text(fileName);

              // Show preview based on file type
              if (file.type.startsWith('image/')) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                      $('#imagePreview').attr('src', e.target.result).show();
                      $('#videoPreview').hide();
                      $('#previewContainer').show();
                  }
                  reader.readAsDataURL(file);
              } else if (file.type.startsWith('video/')) {
                  var videoURL = URL.createObjectURL(file);
                  $('#videoPreview').attr('src', videoURL).show();
                  $('#imagePreview').hide();
                  $('#previewContainer').show();
              }
          }
      });

      // Remove preview handler
      $('#removePreview').on('click', function() {
          // Clear file input
          $('#imageFileInput, #videoFileInput').val('');
          
          // Hide preview
          $('#previewContainer').hide();
          $('#imagePreview, #videoPreview').hide();
          $('#fileNameDisplay').text('');
      });
  });
</script>

@endsection