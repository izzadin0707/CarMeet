<!DOCTYPE html>
<html lang="en" id="htmlMode" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>CarMeet | Dashboard</title>
</head>
<body class="container d-flex justify-content-center align-items-center vh-100">
    <div class="border rounded">
        @if (session('message'))
            <div class="alert alert-danger">
                <span>{{ session('message') }}</span>
            </div>
        @endif
        <div class="card p-3" style="width: 59vh;">
            <h2 class="text-center my-3">Carmeet | Dashboard</h2>
            <div class="card-body">
                {{-- Login --}}
                <div id="loginForm" style="display: block;">
                    <form action="{{ route('dashboard-login') }}" method="post" id="post">
                        @csrf
                        <div class="form-floating mb-4 col">
                            <input type="text" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required autofocus>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-4 col">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating text-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary fs-5" style="border: 1px solid var(--bs-border-color); width: 49%;">Back</a>
                            <button class="btn btn-outline-secondary fs-5" type="submit" style="border: 1px solid var(--bs-border-color); width: 49%;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>