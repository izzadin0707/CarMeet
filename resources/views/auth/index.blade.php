<!DOCTYPE html>
<html lang="en" id="htmlMode" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="style/js/script.js"></script>
    <title>LookME</title>
</head>
<body class="position-relative">
    <div class="position-absolute top-50 start-50 translate-middle">
        @if (session('message'))
        <div id="message">
            <div class="alert alert-danger">
                <span>{{ session('message') }}</span>
            </div>
        </div>
        @endif
        <div class="card p-3" style="width: 59vh;">
            <h1 class="text-center my-3">LookME</h1>
            <div class="card-body">
                {{-- Login --}}
                <div id="loginForm" style="display: block;">
                    <form action="{{ route('user-login') }}" method="post" id="post">
                        @csrf
                        <div class="form-floating mb-4 col">
                            <input type="text" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required autofocus>
                            <label for="floatingInput">Email or Username</label>
                        </div>
                        <div class="form-floating mb-4 col">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-check mb-4 col">
                            <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
                        </div>
                        <div class="form-floating text-center">
                            <button class="btn btn-outline-secondary fs-5" type="submit" style="border: 1px solid var(--bs-border-color); width: 20vh;">Login</button>
                        </div>
                    </form>
                </div>
                
                    
                {{-- Register --}}
                <div id="registerForm" style="display: none;">
                    <form action="/register" method="post" id="post">
                        @csrf
                        <div class="form-floating mb-4 col">
                            <input type="text" class="form-control" id="floatingInput" name="name" placeholder="your username" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-4 col">
                            <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required>
                            <label for="floatingEmail">Email</label>
                        </div>
                        <div class="form-floating mb-4 col">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="password" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        <div class="form-floating mb-4 col">
                            <input type="password" class="form-control" id="floatingPassword" name="password_confirmation" placeholder="confirm password" required>
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <div class="form-floating text-center">
                            <button class="btn btn-outline-secondary fs-5" type="submit" style="border: 1px solid var(--bs-border-color); width: 20vh;">Register</button>
                        </div>
                    </form>
                </div> 
                                
            </div>
        </div>
        <div class="text-end">
            <button class="btn" id="btnRegister" style="border: 1px solid var(--bs-light-border-subtle); border-top: 0px solid; border-radius: 0px 0px 7px 7px;">Register</button>
        </div>
    </div>
    </div>
</body>

</html>