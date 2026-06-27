<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FindIt') — Lost & Found System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --findit-primary: #ff5a1f;
            --findit-dark: #071120;
            --findit-bg: #f4f7fb;
            --findit-surface: #ffffff;
            --findit-soft: #eef4ff;
            --findit-muted: #5b6b84;
        }

        * { box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #f8fbff 0%, var(--findit-bg) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: #14213d;
        }

        .navbar-findit {
            background: linear-gradient(135deg, var(--findit-dark) 0%, #13294d 100%);
            box-shadow: 0 16px 42px rgba(7, 17, 32, 0.16);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .navbar-brand { font-weight: 800; font-size: 1.45rem; letter-spacing: -0.02em; }
        .navbar-brand span { color: var(--findit-primary); }

        .nav-link-soft {
            color: rgba(255,255,255,0.86);
            font-weight: 600;
            padding: 0.6rem 0.9rem;
            border-radius: 999px;
        }
        .nav-link-soft:hover { color: #fff; background: rgba(255,255,255,0.12); }

        .dropdown-menu { border: 0; border-radius: 16px; padding: 10px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.18); }
        .dropdown-item { border-radius: 12px; padding: 10px 12px; }
        .dropdown-item:hover { background: var(--findit-soft); color: var(--findit-dark); }

        .main-content { padding: 28px 0 48px; }

        .card {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 16px 44px rgba(15, 23, 42, 0.08);
        }

        .btn-findit {
            background: linear-gradient(135deg, var(--findit-primary) 0%, #ff7a3d 100%);
            color: white;
            border: none;
            font-weight: 700;
            border-radius: 999px;
            padding: 10px 18px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-findit:hover {
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(255,90,31,0.28);
        }

        .btn-outline-light-soft {
            border: 1px solid rgba(255,255,255,0.24);
            color: white;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 600;
        }

        footer {
            background: linear-gradient(135deg, #071120 0%, #13294d 100%);
            border-top: 1px solid rgba(255,255,255,0.08);
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-dark navbar-findit mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <i class="bi bi-search-heart me-2"></i>Find<span>It</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a class="nav-link-soft" href="{{ route('lost-items.index') }}">Lost</a>
                    <a class="nav-link-soft" href="{{ route('found-items.index') }}">Found</a>
                    <a class="nav-link-soft" href="{{ route('claims.index') }}">Claims</a>
                    <a href="{{ route('notifications.index') }}" class="text-white position-relative me-2" title="Notifications">
                        <i class="bi bi-bell fs-5"></i>
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', auth()->user()->id)
                                ->where('status', 'Unread')->count();
                        @endphp
                        @if ($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background: var(--findit-primary);">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-sm text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @if (auth()->user()->role === 'Admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Admin Panel
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('welcome') }}">
                                <i class="bi bi-house me-2"></i>Home
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('lost-items.index') }}">
                                <i class="bi bi-search me-2"></i>Lost Items
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('found-items.index') }}">
                                <i class="bi bi-check-circle me-2"></i>Found Items
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('claims.index') }}">
                                <i class="bi bi-file-earmark-text me-2"></i>Claims
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form></li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link-soft" href="{{ route('login') }}">Login</a>
                    <a class="nav-link-soft" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <footer class="text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">© 2026 FindIt — Lost & Found System. All rights reserved.</p>
            <small class="text-white-50">Designed for a premium campus recovery experience</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
