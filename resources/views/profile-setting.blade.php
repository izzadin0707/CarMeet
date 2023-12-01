@extends('layouts.main')

@section('container')
<div class="container border rounded-4" style="max-width: 150vh;">
    <div class="row">
        <div class="col-md-4 col-12 p-4 text-center">
            <div id="photo-profile-preview">
                @if ($auth_assets->count() !== 0)
                @foreach ($auth_assets as $asset)
                @if ($asset->status == "photo-profile")
                <img src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" class="photo-profile rounded-circle object-fit-cover" id="photo-profile-view">
                @endif
                @endforeach
                @else
                <img src="{{ URL::asset('photo-profile.png') }}" class="photo-profile rounded-circle object-fit-cover" id="photo-profile-view">
                @endif
            </div>
            <form id="photo-profile-file" enctype="multipart/form-data">
                @csrf
                <div class="m-4">
                    <input type="file" accept="image/*" class="form-control" id="photo-profile" name="photo-profile" id="file">
                    <button type="submit" class="btn btn-light mt-3 w-100" id="btnPhotoProfile" disabled>Save Photo Profile</button>
                </div>
            </form>
        </div>
        <div class="col-md-8 col-12 p-4">
            <form id="change-name" enctype="multipart/form-data">
                @csrf
                <label class="form-label fs-5">Name</label>
                <div class="d-flex">
                    <input type="text" class="form-control form-control-lg me-3" name="name" id="nameInput" value="{{ Auth::user()->name }}" required>
                    <button type="submit" class="btn btn-light px-4 fs-5" id="btnName" disabled>Save</button>
                </div>
                <p class="form-text mt-1">Username : {{ Auth::user()->username }}</p>
            </form>
            <form id="banner-file" enctype="multipart/form-data">
                @csrf
                <label class="form-label fs-5">Banner</label>
                <div class="d-flex justify-content-center align-items-center border rounded-4" id="banner-preview" style="height: 11rem;">
                    @if ($auth_assets->count() == 2)
                    @foreach ($auth_assets as $asset)
                    @if ($asset->status == "banner")
                    <img class="object-fit-cover rounded-4" src="{{ URL::asset('storage/assets/'.$asset->asset.'.png') }}" id="previewImage" alt="Preview Image" style="width: 100%; height: 100%;">
                    @endif
                    @endforeach
                    @else
                    <p>Media Preview</p>
                    @endif
                </div>
                <div class="d-flex mt-3">
                    <input class="form-control form-control-lg me-3" type="file" id="banner-file-input" name="banner-file-input" accept="image/*">
                    <button type="submit" class="btn btn-light px-4 fs-5" id="btnBanner" disabled>Save</button>
                </div>
            </form>
            <form id="background-color" enctype="multipart/form-data">
                @csrf
                <label class="form-label fs-5 mt-4">Background Color</label>
                <div class="d-flex">
                    <input type="color" class="form-control form-control-lg me-3" name="color" id="colorInput" value="{{ Auth::user()->color}}" required>
                    <button type="submit" class="btn btn-light px-4 fs-5" id="btnColor" disabled>Save</button>
                </div>
            </form>
            <form id="font-color" enctype="multipart/form-data">
                @csrf
                <label class="form-label fs-5 mt-4">Font Color</label>
                <div class="d-flex">
                    <input type="color" class="form-control form-control-lg me-3" name="color" id="fontInput" value="{{ Auth::user()->font }}" required>
                    <button type="submit" class="btn btn-light px-4 fs-5" id="btnFont" disabled>Save</button>
                </div>
            </form>
            <div class="d-flex flex-column mt-5">
                <a href="#" onclick="resetTheme()">Default Theme</a>
                <a href="#" onclick="changePassword()">Change Password</a>
            </div>
        </div>
    </div>
</div>

<script>
// Name Input
$(document).ready(function () {
    $("#nameInput").change(function () {
        $("#btnName").removeAttr("disabled");
    });
});

// Banner File Input
$(document).ready(function () {
    $("#banner-file").change(function () {
        $("#btnBanner").removeAttr("disabled");
    });
});

// Photo Profile File Input
$(document).ready(function () {
    $("#photo-profile").change(function () {
        $("#btnPhotoProfile").removeAttr("disabled");
    });
});

// Background Color Input
$(document).ready(function () {
    $("#colorInput").change(function () {
        $("#btnColor").removeAttr("disabled");
    });
});

// Font Color Input
$(document).ready(function () {
    $("#fontInput").change(function () {
        $("#btnFont").removeAttr("disabled");
    });
});

// Banner Preview
$(document).ready(function() {
    $('#banner-file-input').change(function() {
        var input = this;
        var url = window.URL || window.webkitURL;
        var file = input.files[0];
        var fileURL = url.createObjectURL(file);

        if (file.type.startsWith('image/')) {
            $('#banner-preview').html(`<img class="object-fit-cover rounded-4" src="${fileURL}" id="previewImage" alt="Preview Image" style="width: 100%; height: 100%;">`);
        }
    });
});

// Photo Profile Preview
$(document).ready(function() {
    $('#photo-profile').change(function() {
        var input = this;
        var url = window.URL || window.webkitURL;
        var file = input.files[0];
        var fileURL = url.createObjectURL(file);

        if (file.type.startsWith('image/')) {
            $('#photo-profile-preview').html(`<img src="${fileURL}" class="photo-profile rounded-circle object-fit-cover" id="photo-profile-view">`);
        }
    });
});

// Banner
$(document).ready(function () {
    $('#banner-file').submit(function(e){
        e.preventDefault();
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");

        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:'/banner',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data != null){
                    alert("Banner successfully saved!\nPlease refresh to see");
                }else{
                    alert("Failed to save banner.");
                }
                $(".loading").toggleClass("show");
                $(".loading i").toggleClass("show");
                $("#btnBanner").attr("disabled", true);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

// Photo Profile
$(document).ready(function () {
    $('#photo-profile-file').submit(function(e){
        e.preventDefault();
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");

        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:'/photo-profile',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data != null){
                    alert("Profile photo successfully saved!\nPlease refresh to see");
                }else{
                    alert("Failed to save profile photo.");
                }
                $(".loading").toggleClass("show");
                $(".loading i").toggleClass("show");
                $("#btnPhotoProfile").attr("disabled", true);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

// Change Name
$(document).ready(function () {
    $('#change-name').submit(function(e){
        e.preventDefault();
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");

        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:'/change-name',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data != null){
                    alert("Name successfully saved!\nPlease refresh to see");
                }else{
                    alert("Failed to save Name.");
                }
                $(".loading").toggleClass("show");
                $(".loading i").toggleClass("show");
                $("#btnName").attr("disabled", true);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

// Background Color
$(document).ready(function () {
    $('#background-color').submit(function(e){
        e.preventDefault();
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");

        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:'/background-color',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data == true){
                    alert("Background Color successfully saved!");
                }else{
                    alert("Failed to save Backgound Color.");
                }
                $(".loading").toggleClass("show");
                $(".loading i").toggleClass("show");
                $("#btnColor").attr("disabled", true);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

// Font Color
$(document).ready(function () {
    $('#font-color').submit(function(e){
        e.preventDefault();
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");

        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:'/font-color',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data == true){
                    alert("Font Color successfully saved!");
                }else{
                    alert("Failed to save Font Color.");
                }
                $(".loading").toggleClass("show");
                $(".loading i").toggleClass("show");
                $("#btnFont").attr("disabled", true);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

//Change Password
function changePassword() {
    var password = "";
    var new_password = "";
    var verify_password = "";
    if(password = prompt("Input Old Password","")) {
        if(new_password = prompt("Input New Password","")) {
            if(verify_password = prompt("Confirm New Password","")) {
                if(verify_password == new_password) {
                    $(".loading").toggleClass("show");
                    $(".loading i").toggleClass("show");
                    
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
                    $.ajax({
                        type:'POST',
                        url:'/change-password',
                        data: {
                            _token: csrfToken,
                            old_password: password,
                            new_password: new_password,
                        },
                        success:function(data){
                            if(data == true){
                                alert("Password successfully change!");
                            }else{
                                alert("Failed to change password.");
                            }
                            $(".loading").toggleClass("show");
                            $(".loading i").toggleClass("show");
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }else{
                    alert('Confirm Password Wrong!');
                }
            }
        }
    }
}

//Reset Theme
function resetTheme() {
    $(".loading").toggleClass("show");
    $(".loading i").toggleClass("show");
    
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type:'POST',
        url:'/reset-theme',
        data: {
            _token: csrfToken,
        },
        success:function(data){
            if(data == true){
                alert("Theme successfully change!");
            }else{
                alert("Failed to change theme.");
            }
            $(".loading").toggleClass("show");
            $(".loading i").toggleClass("show");
        },
        error: function(data){
            console.log(data);
        }
    });
}
</script>
@endsection