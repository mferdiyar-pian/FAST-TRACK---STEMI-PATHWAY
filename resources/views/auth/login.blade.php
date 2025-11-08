<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FAST TRACK STEMI PATHWAY</title>
    
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
            padding: 20px;
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

        .login-container {
            width: 100%;
            max-width: 380px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
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
        
        .btn-login {
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
            margin-bottom: 1.25rem;
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.1em;
        }

        .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .form-check-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.25);
        }

        .form-check-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #475569;
        }

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

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
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
    <div class="login-container">
        <div class="login-card">
            <div class="form-container">
                <div class="logo-section">
                    <div class="logo-container">
                        <div class="logo-image-container">
                            <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="logo-image" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiByeD0iMTAiIGZpbGw9IiMyNTYzZWIiLz4KPHBhdGggZD0iTTE1IDE1SDQ1VjQ1SDE1VjE1WiIgZmlsbD0id2hpdGUiLz4KPHBhdGggZD0iTTMwIDMwTDQ1IDE1TDMwIDMwWiIgZillPSJ3aGl0ZSIvPgo8L3N2Zz4K'">
                        </div>
                        <div class="logo-text-content">
                            <h1>FAST TRACK</h1>
                            <p class="subtitle">STEMI PATHWAY</p>
                        </div>
                    </div>
                </div>

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

                    <div class="options-row">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="remember" 
                                   name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <a href="{{ route('password.request') }}" class="link-primary-custom">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
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
</body>
</html>