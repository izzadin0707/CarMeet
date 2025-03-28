// navbar
var prevScrollPos = window.pageYOffset;

$(window).scroll(function () {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollPos > currentScrollPos) {
        $("#myNavbar").css("top", "0");
    } else {
        $("#myNavbar").css("top", "-70px");
    }
    prevScrollPos = currentScrollPos;
});

// sidebar
$(document).ready(function () {
    $("#sidebarToggle").click(function () {
        $(".sidebar").toggleClass("show");
        $("html").toggleClass("show");
    });
});

$(document).ready(function() {
    $("#closeSidebar").click(function() {
        $(".sidebar").toggleClass("show");
        $("html").toggleClass("show");
    });
});

$(document).ready(function () {
    $("#categoryToggle").click(function () {
        $(".category-list").toggleClass("show");
    });
});

$(document).ready(function () {
    $("#home").click(function () {
        window.location.href = '/';
    });
});

// commentbar

function showComment(creation_id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/show-comment',
        type: 'POST',
        data: {
            creation_id: creation_id,
            _token: csrfToken
        },
        success: function(response) {
            $('#comment-bar').html(response);
        }
    });
}

$(document).ready(function () {
    $(".btn-comment").click(function () {
        var creation_id = $(this).data("creation-id");
        $(".commentbar").toggleClass("show");
        $("html").toggleClass("show");
        $("#comment_creation_id").attr("value", creation_id);
        showComment(creation_id);
    });
});

$(document).ready(function() {
    $("#closeCommentbar").click(function() {
        $(".commentbar").toggleClass("show");
        $("html").toggleClass("show");
    });
});

$(document).ready(function () {
    $("#home").click(function () {
        window.location.href = '/';
    });
});

// commnent

$(document).ready(function(){
    
    $('#btn-comment').click(function(e){
        var comment = $('#comment').val();
        if(comment.trim() !== ''){
            e.preventDefault();
            var creation_id = $("#comment_creation_id").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
            $(".loading").toggleClass("show");
            $(".loading i").toggleClass("show");
            
        
        
            $.ajax({
                type: 'POST',
                url: '/comment',
                data: {
                    creation_id: creation_id,
                    desc: comment,
                    _token: csrfToken
                },
                success: function(data) {                
                    if (data == true) {
                        $('#comment').val("");
                        $(".loading").toggleClass("show");
                        $(".loading i").toggleClass("show");
                        showComment(creation_id);
                    } else {
                        alert("Failed to submit comment!");
                    }
                }
            });
        }else{
            alert("Please enter a comment!");
        }
    });
});

// auth form
$login = true;

$(document).ready(function () {
    $('#btnRegister').click(function () {
        if($login == true){
            $("#loginForm").css("display", "none");
            $("#registerForm").css("display", "block");
            $('#btnRegister').text("Login");
            $('#auth-text').text("Sudah punya akun?");
            $('#message').html('');
            $login = false;
        }else{
            $("#loginForm").css("display", "block");
            $("#registerForm").css("display", "none");
            $('#btnRegister').text("Register");
            $('#auth-text').text("Belum punya akun?");
            $('#message').html('');
            $login = true;
        }
    })
})

// darkmode

// $(document).ready(function () {
//     $("#darkmodeToggle").click(function () {
//         if($("#darkIcon").attr("class") == 'bi bi-sun-fill fs-5'){
//             $("#darkIcon").attr("class", "bi bi-moon-fill fs-5");
//             $("#htmlMode").attr("data-bs-theme", "dark");
//         }else{
//             $("#darkIcon").attr("class", "bi bi-sun-fill fs-5");
//             $("#htmlMode").attr("data-bs-theme", "light");
//         }
//     });
// });

// Creations Column Height

$(document).ready(function() {
    function setHeightToWidth() {
        $("#creationCard .col").each(function() {
            var lebar = $(this).width();
            $(this).height(lebar);
        });
    }

    setHeightToWidth();

    $(window).resize(function() {
        setHeightToWidth();
    });
});

// Creations Profile Icon

$(document).ready(function() {
    function adjustFontSize() {
        $("#creationCard .col").each(function() {
            var lebarKolom = $(this).width();
            var fontSize = lebarKolom / 10;
            $(this).find("#home_title").css("font-size", fontSize + "px");
        });
    }

    adjustFontSize();

    $(window).resize(function() {
        adjustFontSize();
    });

    function adjustIconSize() {
        $("#creationCard .col").each(function() {
            var lebarKolom = $(this).width();
            var fontSize = lebarKolom / 5;
            $(this).find("#profile_icon").css("width", fontSize + "px");
            $(this).find("#profile_icon").css("height", fontSize + "px");
        });
    }

    adjustIconSize();

    $(window).resize(function() {
        adjustIconSize();
    });
});

// Full Image

$(document).ready(function () {
    $(".postImage").click(function () {
        var width = $(window).width();
        var src = $(this).attr("src");
        $("html").toggleClass("show");
        $("#fullImg").attr("src", src);
        $(".modalImg").toggleClass("show");
        // if (width > 750) {
        //     var src = $(this).attr("src");
        //     $("html").toggleClass("show");
        //     $("#fullImg").attr("src", src);
        //     $(".modalImg").toggleClass("show");
        // }else{
        //     alert('Your screen is too small');
        // }
    });
});

$(document).ready(function () {
    $("#closeImg").click(function () {
        $("html").toggleClass("show");
        $("#fullImg").attr("src", "");
        $(".modalImg").toggleClass("show");
    });
});

// Full Video

$(document).ready(function () {
    $(".postVideo").click(function () {
        var width = $(window).width();
        var src = $("source", this).attr("src");
        $("html").toggleClass("show");
        $("#fullVideo").attr("src", src);
        $(".modalVideo").toggleClass("show");
        // if (width > 750) {
        //     var src = $("source", this).attr("src");
        //     $("html").toggleClass("show");
        //     $("#fullVideo").attr("src", src);
        //     $(".modalVideo").toggleClass("show");
        // }else{
        //     alert('Your screen is too small');
        // }
    });
});

$(document).ready(function () {
    $("#closeVideo").click(function () {
        $("html").toggleClass("show");
        $("#fullVideo").attr("src", "");
        $(".modalVideo").toggleClass("show");
    });
});

// Form File

$(document).ready(function() {
    $('#formFile').change(function() {
        var input = this;
        var url = window.URL || window.webkitURL;
        var file = input.files[0];
        var fileURL = url.createObjectURL(file);

        if (file.type.startsWith('image/')) {
            $('#preview').html(`<img class="m-4" src="${fileURL}" id="previewImage" alt="Preview Image" style="max-height: 345px; width: auto; max-width: 90%;">`);
        }else if (file.type.startsWith('video/')) {
            $('#preview').html(`<video id="previewVideo" src="${fileURL}" controls style="width: auto; max-height: 345px; max-width: 90%;" class="m-4"></video>`);
        }else if (file.type.startsWith('audio/')) {
            $('#preview').html(`<audio src="${fileURL}" controls></audio>`);
        }
    });
});

$(document).ready(function() {
    $('#postCategory').on('change' ,function() {
        if(this.value != null){
            $('#formFile').css('display', 'block');
        }
    });
});

// Post loading

$(document).ready(function() {
    $('#post').submit(function() {
        $(".loading").toggleClass("show");
        $(".loading i").toggleClass("show");
    });
});

// Description Link

$(document).ready(function() {
    var desc = $("#description").text();

    var regex = /(https?:\/\/[^\s]+)/g;
    var matches = desc.match(regex);
    
    if (matches) {
        matches.forEach(function(match) {
            var linkedText = desc.replace(match, '<a href="' + match + '" target="_blank">' + match + '</a>');
            $("#description").html(linkedText);
        });
    } 
});

// Search Bar

$(document).ready(function() {
    $('.search_input input').focus(function() {
        $(this).attr('placeholder', '');
        $(".search_input").toggleClass("focus");
    });
    $('.search_input input').blur(function() {
        $(this).attr('placeholder', 'Search');
        $(".search_input").toggleClass("focus");
    });
});

// Post Like

$(document).ready(function(){

    function dislike(user_id, creation_id, creation_user_id, clickedElement) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        $.ajax({
            type: 'POST',
            url: '/dislike', // Ganti dengan URL Anda
            data: {
                user_id: user_id,
                creation_id: creation_id,
                creation_user_id: creation_user_id,
                _token: csrfToken
            },
            success: function(res) {                
                clickedElement.find("span").text(res.like_counts)
                if (res.result == true) {
                    if (clickedElement.find("i").hasClass('bi-heart-fill')) {
                        clickedElement.find("i").removeClass('bi-heart-fill'); 
                        clickedElement.find("i").addClass('bi-heart'); 
                    }
                }
            }
        });
    }
    
    $('.btn-like').click(function(e){
        e.preventDefault();
        var user_id = $(this).data('user-id');
        var creation_id = $(this).data('creation-id');
        var creation_user_id = $(this).data('creation-user-id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var clickedElement = $(this);

        if (clickedElement.find("i").hasClass('bi-heart')) {
            clickedElement.find("i").removeClass('bi-heart'); 
            clickedElement.find("i").addClass('bi-heart-fill'); 
        } else {
            clickedElement.find("i").removeClass('bi-heart-fill'); 
            clickedElement.find("i").addClass('bi-heart'); 
        }
    
        $.ajax({
            type: 'POST',
            url: '/like', // Ganti dengan URL Anda
            data: {
                user_id: user_id,
                creation_id: creation_id,
                creation_user_id: creation_user_id,
                _token: csrfToken
            },
            success: function(res) {          
                clickedElement.find("span").text(res.like_counts)      
                if (res.result == true) {
                    if (clickedElement.find("i").hasClass('bi-heart')) {
                        clickedElement.find("i").removeClass('bi-heart'); 
                        clickedElement.find("i").addClass('bi-heart-fill'); 
                    }
                } else {
                    dislike(user_id, creation_id, creation_user_id, clickedElement);
                }
            }
        });
    });
});

// Post Save

$(document).ready(function(){

    function unsave(user_id, creation_id, clickedElement) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        $.ajax({
            type: 'POST',
            url: '/unsave', // Ganti dengan URL Anda
            data: {
                user_id: user_id,
                creation_id: creation_id,
                _token: csrfToken
            },
            success: function(res) {                
                if (res.result == true) {
                    if (clickedElement.find("i").hasClass('bi-bookmark-fill')) {
                        clickedElement.find("i").removeClass('bi-bookmark-fill'); 
                        clickedElement.find("i").addClass('bi-bookmark'); 
                    }
                }
            }
        });
    }
    
    $('.btn-save').click(function(e){
        e.preventDefault();
        var user_id = $(this).data('user-id');
        var creation_id = $(this).data('creation-id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var clickedElement = $(this);

        if (clickedElement.find("i").hasClass('bi-bookmark')) {
            clickedElement.find("i").removeClass('bi-bookmark'); 
            clickedElement.find("i").addClass('bi-bookmark-fill'); 
        } else {
            clickedElement.find("i").removeClass('bi-bookmark-fill'); 
            clickedElement.find("i").addClass('bi-bookmark'); 
        }
    
        $.ajax({
            type: 'POST',
            url: '/save', // Ganti dengan URL Anda
            data: {
                user_id: user_id,
                creation_id: creation_id,
                _token: csrfToken
            },
            success: function(res) {                
                if (res.result == true) {
                    if (clickedElement.find("i").hasClass('bi-bookmark')) {
                        clickedElement.find("i").removeClass('bi-bookmark'); 
                        clickedElement.find("i").addClass('bi-bookmark-fill'); 
                    }
                } else {
                    unsave(user_id, creation_id, clickedElement);
                }
            }
        });
    });
});