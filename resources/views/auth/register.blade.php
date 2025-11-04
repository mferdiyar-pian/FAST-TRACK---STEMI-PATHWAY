<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'FAST TRACK STEMI PATHWAY') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Nunito', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            margin: 0;
            position: relative;
            overflow: auto;
        }

        /* Background with gradient using #2563eb */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            clip-path: polygon(0 0, 100% 0, 100% 30%, 0 60%);
            z-index: 0;
            opacity: 0.9;
        }
        
        .register-container {
            width: 100%;
            max-width: 800px;
            position: relative;
            z-index: 1;
        }
        
        .register-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .logo-image-container {
            position: relative;
            padding: 12px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.15);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }
        
        .logo-image {
            height: 50px;
            width: 50px;
            object-fit: contain;
            border-radius: 8px;
        }
        
        .logo-text-content {
            text-align: center;
        }
        
        .logo-text-content h1 {
            color: #2563eb;
            font-weight: 800;
            font-size: 1.4rem;
            line-height: 1.1;
            margin: 0 0 4px 0;
        }
        
        .logo-text-content .subtitle {
            color: #009A9A;
            font-weight: 700;
            font-size: 0.9rem;
            line-height: 1.2;
            margin: 0;
        }

        .welcome-title {
            color: #0f172a;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.7rem 1rem;
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-size: 0.9rem;
            height: 44px;
        }
        
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background: white;
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        .form-control.is-invalid:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: #2563eb;
        }
        
        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.4rem;
            font-weight: 600;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            height: 44px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0.5rem;
        }
        
        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }
        
        /* Alert Styles */
        .alert-custom {
            border-radius: 8px;
            border-left: 4px solid;
            padding: 0.75rem;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
        }
        
        .alert-success-custom {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left-color: #22c55e;
            color: #166534;
        }
        
        .alert-danger-custom {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-left-color: #ef4444;
            color: #991b1b;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .divider span {
            padding: 0 0.75rem;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            background: white;
        }
        
        /* Link Styles */
        .link-primary-custom {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .link-primary-custom:hover {
            color: #1d4ed8;
        }
        
        /* Password Strength */
        .password-strength {
            margin-top: 0.4rem;
            font-size: 0.8rem;
        }

        .strength-bar {
            height: 3px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 0.2rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #ef4444;
            width: 33%;
        }

        .strength-medium {
            background: #f59e0b;
            width: 66%;
        }

        .strength-strong {
            background: #22c55e;
            width: 100%;
        }

        /* Two Column Layout */
        .form-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-columns {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .register-container {
                max-width: 450px;
            }
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 1.5rem;
            }
            
            .logo-image {
                height: 45px;
                width: 45px;
            }
            
            .logo-text-content h1 {
                font-size: 1.3rem;
            }
            
            .logo-text-content .subtitle {
                font-size: 0.85rem;
            }
            
            .welcome-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="form-container">
                <div class="logo-section">
                    <div class="logo-container">
                        <div class="logo-image-container">
                            <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="logo-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiByeD0iMTAiIGZpbGw9IiMyNTYzZWIiLz4KPHBhdGggZD0iTTE1IDE1SDQ1VjQ1SDE1VjE1WiIgZmlsbD0id2hpdGUiLz4KPHBhdGggZD0iTTMwIDMwTDQ1IDE1TDMwIDMwWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cg=='">
                        </div>
                        <div class="logo-text-content">
                            <h1>FAST TRACK</h1>
                            <p class="subtitle">STEMI PATHWAY</p>
                        </div>
                    </div>
                </div>

                 @if (session('success'))
                    <div class="alert-custom alert-success-custom full-width">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span class="fw-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-custom alert-danger-custom full-width">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="mb-1 fw-semibold">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    
                    <div class="form-columns">
                        <!-- Kolom 1 -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="position-relative">
                                    <i class="bi bi-person-fill input-icon"></i>
                                    <input id="name" 
                                           type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus
                                           placeholder="Enter your full name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <div class="position-relative">
                                    <i class="bi bi-at input-icon"></i>
                                    <input id="username" 
                                           type="text" 
                                           class="form-control @error('username') is-invalid @enderror" 
                                           name="username" 
                                           value="{{ old('username') }}" 
                                           required 
                                           autocomplete="username"
                                           placeholder="Choose a username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="position-relative">
                                    <i class="bi bi-lock-fill input-icon"></i>
                                    <input id="password" 
                                           type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Create a password"
                                           oninput="checkPasswordStrength(this.value)">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="password-strength">
                                    <small class="text-muted">Password strength: <span id="strength-text">None</span></small>
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strength-bar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                <div class="position-relative">
                                    <i class="bi bi-lock-fill input-icon"></i>
                                    <input id="password-confirm" 
                                           type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Confirm your password">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Register (Full Width) -->
                        <div class="form-actions">
                            <button type="submit" class="btn-register">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>

                <div class="divider">
                    <span>Already have an account?</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="link-primary-custom d-inline-flex align-items-center fw-bold">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            // Reset
            strengthBar.className = 'strength-fill';
            strengthBar.style.width = '0%';
            
            if (password.length === 0) {
                strengthText.textContent = 'None';
                strengthText.className = '';
                return;
            }
            
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Character variety checks
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
            
            // Update UI based on strength
            if (strength <= 2) {
                strengthBar.className = 'strength-fill strength-weak';
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#ef4444';
            } else if (strength <= 4) {
                strengthBar.className = 'strength-fill strength-medium';
                strengthText.textContent = 'Medium';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.className = 'strength-fill strength-strong';
                strengthText.textContent = 'Strong';
                strengthText.style.color = '#22c55e';
            }
        }

        // Password confirmation check
        document.getElementById('password-confirm').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#e2e8f0';
            }
        });
    </script>
</body>
</html>