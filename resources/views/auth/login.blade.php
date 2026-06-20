<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FindIt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --findit-primary: #e62e04;
            --findit-dark: #1a1a2e;
            --findit-bg: #f5f6fa;
        }

        body {
            background-color: var(--findit-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar-findit {
            background: linear-gradient(135deg, var(--findit-dark) 0%, #16213e 100%);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .navbar-brand span { color: var(--findit-primary); }

        .auth-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .auth-card-header {
            background: var(--findit-dark);
            color: #fff;
            padding: 28px;
            text-align: center;
        }

        .auth-card-body { padding: 32px; background: #fff; }

        .form-label { font-weight: 600; font-size: 0.9rem; color: var(--findit-dark); }

        .form-control:focus {
            border-color: var(--findit-primary);
            box-shadow: 0 0 0 0.2rem rgba(230, 46, 4, 0.15);
        }

        .btn-findit {
            background: var(--findit-primary);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-findit:hover { background: #c92703; color: #fff; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark navbar-findit mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('login') }}">
                <i class="bi bi-search-heart me-2"></i>Find<span>It</span>
            </a>
            <a href="{{ route('register') }}" class="btn btn-sm text-white" style="background: var(--findit-primary);">Register</a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card">
                    <div class="auth-card-header">
                        <i class="bi bi-person-circle fs-1 mb-2 d-block"></i>
                        <h4 class="mb-0 fw-bold">Welcome Back</h4>
                        <p class="mb-0 text-white-50 small">Sign in to your FindIt account</p>
                    </div>
                    <div class="auth-card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-findit w-100 py-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold"
                                style="color: var(--findit-primary);">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
