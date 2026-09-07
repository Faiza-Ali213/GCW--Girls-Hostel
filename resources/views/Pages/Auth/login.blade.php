<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCW Hostel - Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- ===== LOGIN CSS ===== -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    <style>
        /* Password toggle button style */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper .form-control {
            padding-right: 50px;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 5px 8px;
            z-index: 10;
        }
        .toggle-password:hover {
            color: #2d1b3d;
        }
        .toggle-password:focus {
            outline: none;
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- Logo -->
        <div class="logo">
            <i class="fas fa-building"></i>
            <h2>GCW <span>Hostel</span></h2>
            <p>Empowering Your Journey in a Space Built for Her</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-password" id="togglePasswordBtn" aria-label="Show password">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="remember-forgot">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

            <div class="signup-link">
                <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
            </div>

        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput && toggleBtn && eyeIcon) {
                let isPasswordVisible = false;

                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (isPasswordVisible) {
                        passwordInput.type = 'password';
                        eyeIcon.className = 'fas fa-eye';
                        toggleBtn.setAttribute('aria-label', 'Show password');
                        isPasswordVisible = false;
                    } else {
                        passwordInput.type = 'text';
                        eyeIcon.className = 'fas fa-eye-slash';
                        toggleBtn.setAttribute('aria-label', 'Hide password');
                        isPasswordVisible = true;
                    }
                    
                    passwordInput.focus();
                });
            }
        });
    </script>

</body>
</html>