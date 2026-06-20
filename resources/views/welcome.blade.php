<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome — FindIt</title>
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

        .welcome-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .welcome-header {
            background: var(--findit-dark);
            color: #fff;
            padding: 40px 32px;
            text-align: center;
        }

        .welcome-body { padding: 36px; background: #fff; text-align: center; }

        .btn-findit {
            background: var(--findit-primary);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-findit:hover { background: #c92703; color: #fff; }

        .info-badge {
            display: inline-block;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 18px;
            margin: 6px;
            font-size: 0.9rem;
        }

        .info-badge i { color: var(--findit-primary); margin-right: 6px; }
            </style>
    </head>
<body>

    <nav class="navbar navbar-dark navbar-findit mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <i class="bi bi-search-heart me-2"></i>Find<span>It</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card welcome-card">
                    <div class="welcome-header">
                        <i class="bi bi-emoji-smile fs-1 mb-3 d-block"></i>
                        <h2 class="fw-bold mb-2">Welcome, {{ auth()->user()->name }}!</h2>
                        <p class="mb-0 text-white-50">You are now logged in to FindIt</p>
                    </div>
                    <div class="welcome-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <p class="text-muted mb-4">
                            Smart Lost &amp; Found Management System — KUET
                        </p>

                        <div class="mb-4">
                            <span class="info-badge"><i class="bi bi-envelope"></i>{{ auth()->user()->email }}</span>
                            <span class="info-badge"><i class="bi bi-telephone"></i>{{ auth()->user()->phone }}</span>
                            <span class="info-badge"><i class="bi bi-person-badge"></i>{{ auth()->user()->role }}</span>
                </div>

                        <p class="text-muted small mb-0">
                            Your account is active. More features coming soon.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </body>
</html>
