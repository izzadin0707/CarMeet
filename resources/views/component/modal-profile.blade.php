{{-- Modal --}}
<div id="modal-profile" class="modal position-absolute vh-100 vw-100 d-flex flex-column p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-50 shadow border-0">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body p-0">
                <form id="postForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <img src="{{ 
                        $auth_assets->where('status', 'photo-profile')->first()
                            ? URL::asset('storage/assets/' . $auth_assets->where('status', 'banner')->first()->asset . '.png') 
                            : URL::asset('photo-profile.png') }}" 
                        class="w-100" 
                        style="height: 12rem; object-fit: cover;">
                    <div class="p-3">
                        <div class="d-flex mb-3">
                            <img src="{{ 
                                $auth_assets->where('status', 'photo-profile')->first()
                                    ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                                    : URL::asset('photo-profile.png') }}" 
                                class="rounded-circle me-3 border border-5 border-white" 
                                style="width: 9rem; height: 9rem; object-fit: cover; margin-top: -5.5rem; ">
                        </div>
                        <div>
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary px-3" onclick="$('#postForm').submit()">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="change-password" action="{{ route('change-password') }}" method="POST">
                    @csrf
                    <div class="px-3 pb-3">
                        <hr>
                        <div class="mb-3">
                            <span class="fs-6 fw-semibold text-muted">
                                Change New Password
                            </span>
                        </div>
                        <div class="border rounded-3 p-3">
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" onclick="$('#change-password').submit()">Change Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
</div>

<script>
    $(document).ready(function() {
        // Media button click handler
        $('#mediaButtonModal').on('click', function() {
            $('#mediaFileInputModal').click();
        });
    
        // File input change handler
        $('#mediaFileInputModal').on('change', function() {
            // Reset previous preview
            $('#imagePreviewModal, #videoPreviewModal').hide();
            $('#previewContainerModal').hide();
    
            var file = this.files[0];
            if (file) {
                var fileName = file.name;
                $('#fileNameDisplayModal').text(fileName);
    
                // Show preview based on file type
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreviewModal').attr('src', e.target.result).show();
                        $('#videoPreviewModal').hide();
                        $('#previewContainerModal').show();
                    }
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    var videoURL = URL.createObjectURL(file);
                    $('#videoPreviewModal').attr('src', videoURL).show();
                    $('#imagePreviewModal').hide();
                    $('#previewContainerModal').show();
                }
            }
        });
    
        // Remove preview handler
        $('#removePreviewModal').on('click', function() {
            // Clear file input
            $('#mediaFileInputModal').val('');
            
            // Hide preview
            $('#previewContainerModal').hide();
            $('#imagePreviewModal, #videoPreviewModal').hide();
            $('#fileNameDisplayModal').text('');
        });
    });
</script>
    