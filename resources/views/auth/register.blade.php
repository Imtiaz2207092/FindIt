<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — FindIt</title>
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
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card auth-card">
                    <div class="auth-card-header">
                        <i class="bi bi-person-plus fs-1 mb-2 d-block"></i>
                        <h4 class="mb-0 fw-bold">Create Account</h4>
                        <p class="mb-0 text-white-50 small">Join FindIt to report and search items</p>
                    </div>
                    <div class="auth-card-body">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="you@example.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimum 8 characters" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Re-enter your password" required>
                            </div>

                            <button type="submit" class="btn btn-findit w-100 py-2">
                                <i class="bi bi-person-check me-1"></i> Create Account
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold"
                                style="color: var(--findit-primary);">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
