{{-- Modal --}}
<div id="modal-profile" class="modal position-absolute vh-100 vw-100 d-flex flex-column p-4 d-none" style="z-index: 1000; background-color: rgba(0,0,0,0.65); opacity: 0;">
    <div class="w-100 d-flex align-items-start justify-content-center">
        <div class="card w-100 w-md-50 shadow border-0">
            <div class="card-header py-0 px-2">
                <i class="bi bi-x fs-3 text-muted modal-close" style="cursor: pointer;"></i>
            </div>
            <div class="card-body p-0">
                <form id="profileUpdate" action="{{ route('profile-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photo-profile" id="photo-profile" accept="image/*" style="display:none;" />
                    <input type="file" name="banner" id="banner" accept="image/*" style="display:none;" />
                    <img src="{{ 
                        $auth_assets->where('status', 'banner')->first()
                            ? URL::asset('storage/assets/' . $auth_assets->where('status', 'banner')->first()->asset . '.png') 
                            : URL::asset('photo-profile.png') }}" 
                        data-old="{{ 
                            $auth_assets->where('status', 'banner')->first()
                                ? URL::asset('storage/assets/' . $auth_assets->where('status', 'banner')->first()->asset . '.png') 
                                : URL::asset('photo-profile.png') }}" 
                        class="w-100" 
                        style="height: 12rem; object-fit: cover;"
                        id="BannerPreview">
                    <div class="p-3">
                        <div class="d-flex mb-3">
                            <img src="{{ 
                                $auth_assets->where('status', 'photo-profile')->first()
                                    ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                                    : URL::asset('photo-profile.png') }}"
                                data-old="{{ 
                                    $auth_assets->where('status', 'photo-profile')->first()
                                        ? URL::asset('storage/assets/' . $auth_assets->where('status', 'photo-profile')->first()->asset . '.png') 
                                        : URL::asset('photo-profile.png') }}" 
                                class="rounded-circle me-3 border border-5 border-white" 
                                style="width: 9rem; height: 9rem; object-fit: cover; margin-top: -5.5rem; "
                                id="ProfilePreview">
                        </div>
                        <div>
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ $user->name }}" data-old="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" data-old="{{ $user->email }}" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary px-3" onclick="$('#profileUpdate').submit()">Save</button>
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

<style>
    #ProfilePreview {
        z-index: 100;
    }
    
    #ProfilePreview, #BannerPreview {
        cursor: pointer;
        transition: 0.3s ease;
    }

    #ProfilePreview:hover, #BannerPreview:hover {
        filter: brightness(0.8);
    }
</style>

<script>
    $(document).ready(function() {
        $('.modal-close').on('click', function() {
            $('#username').val($('#username').data('old'));
            $('#email').val($('#email').data('old'));
            $('#password').val('');
            $('#new_password').val('');
            $('#password_confirmation').val('');
            $('#photo-profile').val('');
            $('#banner').val('');
            $('#ProfilePreview').attr('src', $('#ProfilePreview').data('old'));
            $('#BannerPreview').attr('src', $('#BannerPreview').data('old'));
        });

        $('#profile-setting-btn').on('click', function() {
            $('#username').val($('#username').data('old'));
            $('#email').val($('#email').data('old'));
            $('#password').val('');
            $('#new_password').val('');
            $('#password_confirmation').val('');
            $('#photo-profile').val('');
            $('#banner').val('');
            $('#ProfilePreview').attr('src', $('#ProfilePreview').data('old'));
            $('#BannerPreview').attr('src', $('#BannerPreview').data('old'));
        });

        $('#ProfilePreview').on('click', function() {
            $('#photo-profile').click();
        });

        $('#BannerPreview').on('click', function() {
            $('#banner').click();
        });
    
        $('#photo-profile').on('change', function() {
            var file = this.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#ProfilePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });

        $('#banner').on('change', function() {
            var file = this.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#BannerPreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    });
</script>
    