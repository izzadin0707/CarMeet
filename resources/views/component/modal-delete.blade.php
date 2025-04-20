{{-- Modal --}}
<div id="modal-delete" class="modal position-absolute vh-100 vw-100 d-flex justify-content-center p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-center justify-content-center">
        <div class="card w-100 w-md-25 shadow border-0">
            {{-- <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div> --}}
            <div class="card-body">
                <form action="" method="">
                    @csrf
                    {{-- <h5>Delete?</h5> --}}
                    <p>This action cannot be undone and will be permanently removed.</p>
                    <div class="d-flex gap-3 mt-4">
                        <button type="button" class="btn btn-outline-secondary w-100 modal-close">Cancel</button>
                        <button type="submit" class="btn btn-danger w-100">Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
</script>
    