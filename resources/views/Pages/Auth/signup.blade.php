<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCW Hostel - Sign Up</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- ===== SIGNUP CSS ===== -->
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    
    <!-- ===== PASSWORD TOGGLE CSS ===== -->
    <style>
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
            background: none;
            border: none;
            cursor: pointer;
            color: #8B6B4A;
            font-size: 16px;
            padding: 5px;
            transition: color 0.2s ease;
            z-index: 10;
        }
        
        .toggle-password:hover {
            color: #4A3228;
        }
        
        .toggle-password:focus {
            outline: none;
        }
    </style>
    
</head>
<body>

    <div class="signup-container">
        
        <!-- Logo -->
        <div class="logo">
            <i class="fas fa-building"></i>
            <h2>GCW <span>Hostel</span></h2>
            <p>Create your account to get started</p>
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

        <!-- Signup Form -->
        <form class="signup-form" action="{{ route('signup') }}" method="POST">
            @csrf

            <div class="form-group">
                <label><i class="fas fa-user"></i> Full Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone"></i> Phone Number</label>
                <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
            </div>

            <!-- ✅ Password with Show/Hide -->
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" 
                           class="form-control" 
                           name="password" 
                           id="password" 
                           placeholder="Create a password" 
                           required>
                    <button type="button" 
                            class="toggle-password" 
                            onclick="togglePassword('password', 'eyeIcon1')"
                            title="Show/Hide Password">
                        <i class="fas fa-eye" id="eyeIcon1"></i>
                    </button>
                </div>
            </div>

            <!-- ✅ Confirm Password with Show/Hide -->
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           placeholder="Confirm your password" 
                           required>
                    <button type="button" 
                            class="toggle-password" 
                            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            title="Show/Hide Password">
                        <i class="fas fa-eye" id="eyeIcon2"></i>
                    </button>
                </div>
            </div>

            <div class="terms">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn-signup">
                <i class="fas fa-user-plus"></i> Create Account
            </button>

            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>

        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Password Toggle JavaScript -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>