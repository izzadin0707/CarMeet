{{-- Modal --}}
<div id="modal-post" class="modal position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-50 shadow border-0">
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
                                <input type="file" name="file" id="mediaFileInputModal" accept="image/*,video/*" style="display:none;" />
                                
                                <!-- Single button to trigger file selection -->
                                <button type="button" id="mediaButtonModal" class="btn btn-outline-secondary">
                                    <i class="bi bi-image"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary">Posting</button>
                    </div>
            
                    <!-- Preview Container -->
                    <div id="previewContainerModal" class="mt-3" style="display:none;">
                        <div class="d-flex align-items-center">
                            <button type="button" id="removePreviewModal" class="btn btn-sm btn-outline-danger me-2">
                                <i class="bi bi-x"></i>
                            </button>
                            <span id="fileNameDisplayModal" class="me-2"></span>
                        </div>
                        <div id="mediaPreview" class="mt-2">
                            <img id="imagePreviewModal" style="max-width: 100%; max-height: 300px; display:none;" />
                            <video id="videoPreviewModal" controls style="max-width: 100%; max-height: 300px; display:none;"></video>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    