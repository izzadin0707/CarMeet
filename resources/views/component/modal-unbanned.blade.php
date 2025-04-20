{{-- Modal --}}
<div id="modal-unban" class="modal position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-25 shadow border-0">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title mb-3">Unban User</h5>
                <p class="text-muted mb-3">Are you sure you want to unban this user?</p>
                <form id="UnbanForm" action="{{ route('unban-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="unban_user_id">
                    <div class="d-grid">
                        <button type="button" class="btn btn-success text-start unban-user">
                            <i class="bi bi-unlock me-2"></i>Unban User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle unban user
    $('.unban-user').click(function() {
        const userId = $('#unban_user_id').val();

        $.ajax({
            url: '{{ route("unban-user") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId
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
                console.log('An error occurred while unbanning the user');
            }
        });
    });
});
</script>