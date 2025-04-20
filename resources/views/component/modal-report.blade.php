{{-- Modal --}}
<div id="modal-report" class="modal position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-25 shadow border-0">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body">
                <form id="ReportForm" action="{{ route('store-report') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="id" id="id">
                    {{-- Report Types Checkboxes --}}
                    <div class="mb-3">
                        <p class="text-muted mb-2">Select report reason:</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="spam" id="reportSpam" style="cursor: pointer;">
                            <label class="form-check-label" for="reportSpam" style="cursor: pointer;">Spam</label>
                            <small class="d-block text-muted">Misleading or repetitive posts that don't follow community guidelines</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="harassment" id="reportHarassment" style="cursor: pointer;">
                            <label class="form-check-label" for="reportHarassment" style="cursor: pointer;">Harassment</label>
                            <small class="d-block text-muted">Bullying, threatening, or targeted abuse towards others</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="inappropriate" id="reportInappropriate" style="cursor: pointer;">
                            <label class="form-check-label" for="reportInappropriate" style="cursor: pointer;">Inappropriate Content</label>
                            <small class="d-block text-muted">Content that contains explicit, offensive, or unsuitable material</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="violence" id="reportViolence" style="cursor: pointer;">
                            <label class="form-check-label" for="reportViolence" style="cursor: pointer;">Violence</label>
                            <small class="d-block text-muted">Content promoting or glorifying violence or extreme harm</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="hate_speech" id="reportHateSpeech" style="cursor: pointer;">
                            <label class="form-check-label" for="reportHateSpeech" style="cursor: pointer;">Hate Speech</label>
                            <small class="d-block text-muted">Content that promotes hate or discrimination against protected groups</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="misinformation" id="reportMisinformation" style="cursor: pointer;">
                            <label class="form-check-label" for="reportMisinformation" style="cursor: pointer;">Misinformation</label>
                            <small class="d-block text-muted">False or misleading information that could cause harm</small>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input report-type" type="checkbox" value="copyright" id="reportCopyright" style="cursor: pointer;">
                            <label class="form-check-label" for="reportCopyright" style="cursor: pointer;">Copyright Violation</label>
                            <small class="d-block text-muted">Content that violates intellectual property rights or copyright laws</small>
                        </div>
                    </div>
            
                    {{-- Hidden input for combined values --}}
                    <input type="hidden" name="report_types" id="reportTypes">

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Update hidden input when checkboxes change
        $('.report-type').on('change', function() {
            var selectedTypes = [];
            
            // Collect all checked values
            $('.report-type:checked').each(function() {
                selectedTypes.push($(this).val());
            });
            
            // Join values with comma and set to hidden input
            $('#reportTypes').val(selectedTypes.join(','));
        });
    
        // Handle form submission
        $('#ReportForm').on('submit', function(e) {
            e.preventDefault();
    
            if (!$('#reportTypes').val()) {
                alert('Please select at least one reason for reporting');
                return;
            }
    
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#modal-report .modal-close').trigger('click');
                        console.log(response.message);
                        location.reload();
                    } else {
                        console.log(response.message);
                    }
                },
                error: function(xhr) {
                    console.log('Error submitting report');
                }
            });
        });
    });
</script>
    