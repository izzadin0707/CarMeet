<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @include('layouts.import')
  <title>CarMeet</title>
</head>
{{-- Modal --}}
<div id="modal" class="position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.5); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-50">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body">
                <form id="postForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex mb-3">
                        <img src="{{ 
                            $auth_assets->where('status', 'photo-profile')->first()
                                ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                                : URL::asset('photo-profile.png') }}" 
                            class="rounded-circle me-3" 
                            style="width: 40px; height: 40px; object-fit: cover;">
                        <textarea name="desc" class="form-control" placeholder="Apa yang ingin Anda bagikan?" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center" style="margin-left: 3.5rem;">
                            <div>
                                <!-- Single file input for both image and video -->
                                <input type="file" name="file" id="mediaFileInput" accept="image/*,video/*" style="display:none;" />
                                
                                <!-- Single button to trigger file selection -->
                                <button type="button" id="mediaButton" class="btn btn-outline-secondary">
                                    <i class="bi bi-image"></i>
                                </button>
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
    </div>
</div>
<body style="overflow: hidden; height: 100vh;">
  <div class="container-fluid h-100">
      <div class="row vh-100">
          {{-- Sidebar Kiri --}}
          <div class="col-md-3 py-4 d-none d-md-block position-sticky">
            @include('layouts.v_leftsidebar')
          </div>
  
          {{-- Konten Utama --}}
          <div class="col-md-6 col-12 py-4 h-100 overflow-y-scroll">
              @yield('content')
          </div>
  
          {{-- Sidebar Kanan --}}
          <div class="col-md-3 py-4 d-none d-md-block">
            @include('layouts.v_rightsidebar')
          </div>
      </div>
  </div>
</body>
  @push('styles')
  <style>
      body {
          background-color: #f8f9fa;
      }
      .card {
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      }
      .list-group-item:hover {
          background-color: #f1f3f5;
      }
  </style>
  @endpush

  @push('scripts')
  <script>
      // Tambahkan interaksi dinamis di sini
      document.addEventListener('DOMContentLoaded', function() {
          // Contoh: Animasi hover pada postingan
          const postCards = document.querySelectorAll('.card-img-top');
          postCards.forEach(card => {
              card.addEventListener('mouseenter', function() {
                  this.style.transform = 'scale(1.02)';
                  this.style.transition = 'transform 0.3s ease';
              });
              card.addEventListener('mouseleave', function() {
                  this.style.transform = 'scale(1)';
              });
          });
      });
  </script>
  @endpush
</html>
