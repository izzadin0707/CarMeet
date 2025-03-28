<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarMeet - Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .auth-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .auth-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .auth-body {
            padding: 30px;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .toggle-link {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h2 class="mb-0">CarMeet</h2>
        </div>
        
        <div class="auth-body">
            {{-- Login Form --}}
            <div id="loginForm" style="display: {{ session('showRegister') ? 'none' : 'block' }};">
                <h4 class="text-center mb-4">Login to Your Account</h4>
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('user-login') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   class="form-control @if(!session('showRegister')) @error('email') is-invalid @enderror @endif" 
                                   id="loginEmail" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email" 
                                   required>
                        </div>
                        @if(!session('showRegister'))
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   class="form-control @if(!session('showRegister')) @error('password') is-invalid @enderror @endif" 
                                   id="loginPassword" 
                                   name="password" 
                                   placeholder="Enter your password" 
                                   required>
                        </div>
                        @if(!session('showRegister'))
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
                        <label class="form-check-label" for="rememberCheck">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>

                    <div class="text-center mt-3">
                        <span>Don't have an account? </span>
                        <a href="#" id="switchToRegister" class="toggle-link">Register</a>
                    </div>
                </form>
            </div>

            {{-- Register Form --}}
            <div id="registerForm" style="display: {{ session('showRegister') ? 'block' : 'none' }};">
                <h4 class="text-center mb-4">Create an Account</h4>
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="/register" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="registerUsername" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" 
                                   class="form-control @if(session('showRegister')) @error('name') is-invalid @enderror @endif" 
                                   id="registerUsername" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Choose a username" 
                                   required>
                        </div>
                        @if(session('showRegister'))
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   class="form-control @if(session('showRegister')) @error('email') is-invalid @enderror @endif" 
                                   id="registerEmail" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email" 
                                   required>
                        </div>
                        @if(session('showRegister'))
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   class="form-control @if(session('showRegister')) @error('password') is-invalid @enderror @endif" 
                                   id="registerPassword" 
                                   name="password" 
                                   placeholder="Create a password" 
                                   required>
                        </div>
                        @if(session('showRegister'))
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="registerPasswordConfirm" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" 
                                   class="form-control @if(session('showRegister')) @error('password_confirmation') is-invalid @enderror @endif" 
                                   id="registerPasswordConfirm" 
                                   name="password_confirmation" 
                                   placeholder="Confirm your password" 
                                   required>
                        </div>
                        @if(session('showRegister'))
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Register</button>

                    <div class="text-center mt-3">
                        <span>Already have an account? </span>
                        <a href="#" id="switchToLogin" class="toggle-link">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle between Login and Register
        document.getElementById('switchToRegister')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        });

        document.getElementById('switchToLogin')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
        });
    </script>
</body>
</html>