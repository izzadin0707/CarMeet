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
@include('component.modal-post')
@include('component.modal-delete')
@include('component.modal-profile')
@include('component.modal-report')
@include('component.modal-banned')
@include('component.modal-unbanned')
<body style="overflow: hidden; height: 100vh;">
  <div class="container-fluid h-100">
      <div class="row vh-100">
          {{-- Sidebar Kiri --}}
          <div class="col-md-3 py-4 d-none d-md-block position-sticky">
            @include('layouts.v_leftsidebar')
          </div>
  
          {{-- Konten Utama --}}
          <div class="col-md-6 col-12 py-4 h-100 overflow-y-scroll border-start border-end">
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
