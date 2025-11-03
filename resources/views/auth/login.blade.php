<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'FAST TRACK STEMI PATHWAY') }}</title>
    
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
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
            clip-path: polygon(0 0, 100% 0, 100% 20%, 0 40%);
            z-index: 0;
            opacity: 0.03;
        }
        
        .login-container {
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            display: flex;
            flex-wrap: wrap;
            min-height: 580px;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
            border-radius: 21px;
            z-index: -1;
            opacity: 0.1;
        }

        /* Two-column layout */
        .left-column {
            flex: 1;
            min-width: 300px;
            padding-right: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .right-column {
            flex: 1;
            min-width: 300px;
            border-left: 1px solid #e2e8f0;
            padding-left: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Logo Styles */
        .logo-section {
            text-align: center;
        }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .logo-image-container {
            position: relative;
            padding: 16px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.12);
            border: 1px solid rgba(6, 182, 212, 0.08);
        }
        
        .logo-image {
            height: 60px;
            width: 60px;
            object-fit: contain;
            border-radius: 10px;
            filter: drop-shadow(0 4px 8px rgba(6, 182, 212, 0.15));
        }
        
        .logo-text-content {
            text-align: center;
        }
        
        .logo-text-content h1 {
            color: #06b6d4;
            font-weight: 800;
            font-size: 1.5rem;
            line-height: 1.1;
            margin: 0 0 2px 0;
            letter-spacing: -0.3px;
        }
        
        .logo-text-content .subtitle {
            color: #0ea5e9;
            font-weight: 700;
            font-size: 0.9rem;
            line-height: 1.2;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .logo-text-content .tagline {
            color: #64748b;
            font-weight: 600;
            font-size: 0.75rem;
            margin: 6px 0 0 0;
            line-height: 1.3;
        }
        
        /* Form Styles - FIXED PADDING */
        .form-control {
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-size: 0.9rem;
            height: 48px;
            line-height: 1.5;
        }
        
        .form-control:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.15);
            background: white;
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
            color: #06b6d4;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
            height: 48px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(6, 182, 212, 0.4);
            background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
        }
        
        /* Alert Styles */
        .alert-custom {
            border-radius: 10px;
            border-left: 4px solid;
            padding: 0.875rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
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
            margin: 1.25rem 0;
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
            font-weight: 600;
            background: white;
        }
        
        /* Link Styles */
        .link-primary-custom {
            color: #06b6d4;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .link-primary-custom:hover {
            color: #0891b2;
        }
        
        /* Footer */
        .footer-text {
            text-align: center;
            color: #64748b;
            font-size: 0.75rem;
            line-height: 1.4;
        }
        
        .footer-text a {
            color: #06b6d4;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-text a:hover {
            color: #0891b2;
        }

        /* Checkbox */
        .form-check-input:checked {
            background-color: #06b6d4;
            border-color: #06b6d4;
        }

        .form-check-input:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 0.15rem rgba(6, 182, 212, 0.25);
        }

        .form-check-label {
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Floating Shapes */
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.06) 0%, rgba(14, 165, 233, 0.03) 100%);
            border-radius: 50%;
            animation: float 10s ease-in-out infinite;
        }

        .shape-1 {
            width: 40px;
            height: 40px;
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            top: 65%;
            right: 10%;
            animation-delay: 3s;
        }

        .shape-3 {
            width: 30px;
            height: 30px;
            bottom: 25%;
            left: 20%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(3deg);
            }
        }
        
        /* Welcome section styling */
        .welcome-section {
            margin-top: 1.5rem;
        }

        .welcome-section h3 {
            color: #06b6d4;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .welcome-section .lead {
            color: #64748b;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .benefit-icon {
            color: #06b6d4;
            margin-right: 0.75rem;
            font-size: 1rem;
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        .benefit-text {
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Form spacing adjustments */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                max-width: 100%;
            }
            
            .login-card {
                flex-direction: column;
                padding: 1.75rem 1.5rem;
                margin: 0 5px;
                min-height: auto;
            }
            
            .left-column, .right-column {
                padding: 0;
                border-left: none;
                min-width: 100%;
            }
            
            .right-column {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e2e8f0;
            }
            
            .logo-image {
                height: 55px;
                width: 55px;
            }
            
            .logo-text-content h1 {
                font-size: 1.35rem;
            }
            
            .logo-text-content .subtitle {
                font-size: 0.85rem;
            }

            .logo-text-content .tagline {
                font-size: 0.7rem;
            }

            .logo-image-container {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem 1.25rem;
            }
            
            .logo-image {
                height: 50px;
                width: 50px;
            }
            
            .logo-text-content h1 {
                font-size: 1.25rem;
            }
        }

        /* Ensure no scroll on all screen sizes */
        @media (max-height: 600px) {
            body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .login-card {
                margin-top: 10px;
                margin-bottom: 10px;
            }
        }

        /* Compact layout for very small screens */
        .compact-layout {
            transform: scale(0.95);
            transform-origin: center;
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <!-- Left Column: Logo and Welcome Info -->
            <div class="left-column">
                <div>
                    <div class="logo-section">
                        <div class="logo-container">
                            <div class="logo-image-container">
                                <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="logo-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiByeD0iMTAiIGZpbGw9IiMwNkI2RDQiLz4KPHBhdGggZD0iTTE1IDE1SDQ1VjQ1SDE1VjE1WiIgZmlsbD0id2hpdGUiLz4KPHBhdGggZD0iTTMwIDMwTDQ1IDE1TDMwIDMwWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cg=='">
                            </div>
                            <div class="logo-text-content">
                                <h1>FAST TRACK</h1>
                                <p class="subtitle">STEMI PATHWAY</p>
                                <p class="tagline">Advanced Medical Care System</p>
                            </div>
                        </div>
                    </div>

                    <div class="welcome-section">
                        <h3>Welcome Back</h3>
                        <p class="lead">Sign in to continue your medical journey</p>
                        
                        <div class="benefit-item">
                            <i class="bi bi-shield-check benefit-icon"></i>
                            <div class="benefit-text">Secure access to patient data and protocols</div>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-graph-up benefit-icon"></i>
                            <div class="benefit-text">Track patient outcomes and progress</div>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-people benefit-icon"></i>
                            <div class="benefit-text">Collaborate with your medical team</div>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-journal-text benefit-icon"></i>
                            <div class="benefit-text">Access latest medical guidelines</div>
                        </div>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="footer-text">
                    <p class="mb-2">
                        By signing in, you agree to our 
                        <a href="#">Terms of Service</a> and 
                        <a href="#">Privacy Policy</a>
                    </p>
                    <p class="mb-0">© 2025 FAST TRACK STEMI PATHWAY. All rights reserved.</p>
                </div>
            </div>

            <!-- Right Column: Login Form -->
            <div class="right-column">
                @if (session('success'))
                    <div class="alert-custom alert-success-custom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span class="fw-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-custom alert-danger-custom">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="mb-1 fw-semibold" style="font-size: 0.85rem;">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="position-relative">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input id="username" 
                                   type="text" 
                                   class="form-control" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autocomplete="username" 
                                   autofocus
                                   placeholder="Enter your username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="position-relative">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input id="password" 
                                   type="password" 
                                   class="form-control" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Enter your password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="remember" 
                                   name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-primary-custom small">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login w-100 d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Sign In
                    </button>
                </form>

                <div class="divider">
                    <span>New to FAST TRACK?</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="link-primary-custom d-inline-flex align-items-center fw-bold">
                        Create an account
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-adjust layout for very small screens
        function adjustLayout() {
            const container = document.querySelector('.login-container');
            const card = document.querySelector('.login-card');
            const body = document.body;
            
            if (window.innerHeight < 600) {
                body.style.alignItems = 'flex-start';
                body.style.paddingTop = '5px';
                card.classList.add('compact-layout');
            } else {
                body.style.alignItems = 'center';
                body.style.paddingTop = '15px';
                card.classList.remove('compact-layout');
            }
        }

        // Initial adjustment
        adjustLayout();
        
        // Adjust on resize
        window.addEventListener('resize', adjustLayout);
        window.addEventListener('orientationchange', adjustLayout);
    </script>
</body>
</html>