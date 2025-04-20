{{-- Modal --}}
<div id="modal-banned" class="modal position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-25 shadow border-0">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title mb-3">Ban User</h5>
                <form id="BanForm" action="{{ route('ban-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="ban_user_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Select Ban Duration</label>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-danger text-start ban-duration" data-days="1">
                                <i class="bi bi-clock me-2"></i>1 Day
                            </button>
                            <button type="button" class="btn btn-outline-danger text-start ban-duration" data-days="7">
                                <i class="bi bi-calendar-week me-2"></i>7 Days
                            </button>
                            <button type="button" class="btn btn-outline-danger text-start ban-duration" data-days="30">
                                <i class="bi bi-calendar me-2"></i>1 Month
                            </button>
                            <button type="button" class="btn btn-outline-danger text-start ban-duration" data-days="90">
                                <i class="bi bi-calendar3 me-2"></i>3 Months
                            </button>
                            <button type="button" class="btn btn-outline-danger text-start ban-duration" data-days="36500">
                                <i class="bi bi-infinity me-2"></i>Permanently
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle ban duration selection
    $('.ban-duration').click(function() {
        const days = $(this).data('days');
        const userId = $('#ban_user_id').val();

        $.ajax({
            url: '{{ route("ban-user") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                banned: days
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.message);
                    location.reload();
                } else {
                    console.log(response.message);
                }
            },
            error: function() {
                console.log('An error occurred while banning the user');
            }
        });
    });
});
</script>