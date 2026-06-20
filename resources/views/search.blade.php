<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIt — Search Lost Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --findit-primary: #e62e04;
            --findit-dark: #1a1a2e;
            --findit-muted: #6c757d;
            --findit-bg: #f5f6fa;
            --findit-card: #ffffff;
            --findit-border: #e9ecef;
        }

        body {
            background-color: var(--findit-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .navbar-findit {
            background: linear-gradient(135deg, var(--findit-dark) 0%, #16213e 100%);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .navbar-brand span {
            color: var(--findit-primary);
        }

        .filter-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 20px;
        }

        .filter-card .card-header {
            background: var(--findit-dark);
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: 14px 18px;
        }

        .filter-card .card-body {
            padding: 20px;
        }

        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--findit-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .form-check-input:checked {
            background-color: var(--findit-primary);
            border-color: var(--findit-primary);
        }

        .btn-filter {
            background: var(--findit-primary);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            background: #c92703;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(230, 46, 4, 0.35);
        }

        .btn-reset {
            border-radius: 8px;
            font-weight: 500;
        }

        .results-header {
            background: var(--findit-card);
            border-radius: 12px;
            padding: 18px 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        .results-count {
            color: var(--findit-primary);
            font-weight: 700;
        }

        .item-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: all 0.25s ease;
            height: 100%;
        }

        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
        }

        .item-card-img {
            height: 160px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.85);
            font-size: 3rem;
        }

        .item-card .card-body {
            padding: 18px;
        }

        .item-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--findit-dark);
            margin-bottom: 8px;
        }

        .item-desc {
            font-size: 0.85rem;
            color: var(--findit-muted);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
        }

        .badge-category {
            background: #e8f4fd;
            color: #0d6efd;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .badge-status {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .badge-lost {
            background: #fde8e8;
            color: #dc3545;
        }

        .badge-matched {
            background: #fff3cd;
            color: #856404;
        }

        .badge-claimed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-returned {
            background: #d4edda;
            color: #155724;
        }

        .item-meta {
            font-size: 0.82rem;
            color: var(--findit-muted);
        }

        .item-meta i {
            color: var(--findit-primary);
            margin-right: 4px;
        }

        .btn-details {
            background: var(--findit-dark);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .btn-details:hover {
            background: var(--findit-primary);
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--findit-card);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #dee2e6;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark navbar-findit mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('search') }}">
                <i class="bi bi-search-heart me-2"></i>Find<span>It</span>
            </a>
            <span class="text-white-50 d-none d-md-inline">Smart Lost &amp; Found Management System</span>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row g-4">

            {{-- Left Sidebar: Filters --}}
            <div class="col-lg-3">
                <div class="card filter-card">
                    <div class="card-header">
                        <i class="bi bi-funnel me-2"></i>Filter Items
                    </div>
                    <div class="card-body">
                        <form action="{{ route('search') }}" method="GET">

                            <div class="mb-3">
                                <label for="search" class="filter-label">Search</label>
                                <input
                                    type="text"
                                    name="search"
                                    id="search"
                                    class="form-control"
                                    placeholder="Title or description..."
                                    value="{{ request('search') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <span class="filter-label d-block">Category</span>
                                @forelse ($categories as $category)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="category_id[]"
                                            value="{{ $category->id }}"
                                            id="cat_{{ $category->id }}"
                                            @checked(in_array($category->id, (array) request('category_id', [])))
                                        >
                                        <label class="form-check-label" for="cat_{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No categories available.</p>
                                @endforelse
                            </div>

                            <div class="mb-4">
                                <span class="filter-label d-block">Status</span>
                                @foreach ($statuses as $status)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="status[]"
                                            value="{{ $status }}"
                                            id="status_{{ $status }}"
                                            @checked(in_array($status, (array) request('status', [])))
                                        >
                                        <label class="form-check-label" for="status_{{ $status }}">
                                            {{ $status }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-filter w-100 mb-2">
                                <i class="bi bi-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('search') }}" class="btn btn-outline-secondary btn-reset w-100">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Section: Results --}}
            <div class="col-lg-9">
                <div class="results-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="mb-0 fw-bold">Search Results</h4>
                        <small class="text-muted">Browse and filter lost item reports</small>
                    </div>
                    <div>
                        <span class="results-count">{{ $items->count() }}</span>
                        <span class="text-muted"> item(s) found</span>
                    </div>
                </div>

                @if ($items->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-inbox d-block mb-3"></i>
                        <h5 class="text-muted">No items found</h5>
                        <p class="text-muted mb-0">Try adjusting your search or filter criteria.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($items as $item)
                            @php
                                $statusClass = match ($item->status) {
                                    'Lost' => 'badge-lost',
                                    'Matched' => 'badge-matched',
                                    'Claimed' => 'badge-claimed',
                                    'Returned' => 'badge-returned',
                                    default => 'badge-lost',
                                };

                                $iconClass = match ($item->category_name) {
                                    'Electronics' => 'bi-phone',
                                    'Documents' => 'bi-file-earmark-text',
                                    'Wallets' => 'bi-wallet2',
                                    default => 'bi-box-seam',
                                };
                            @endphp

                            <div class="col-md-6 col-xl-4">
                                <div class="card item-card">
                                    <div class="item-card-img">
                                        <i class="bi {{ $iconClass }}"></i>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="item-title">{{ $item->title }}</h5>
                                        <p class="item-desc">{{ $item->description }}</p>

                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge-category">
                                                <i class="bi bi-tag me-1"></i>{{ $item->category_name }}
                                            </span>
                                            <span class="badge-status {{ $statusClass }}">
                                                {{ $item->status }}
                                            </span>
                                        </div>

                                        <div class="item-meta mb-1">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $item->location }}
                                        </div>
                                        <div class="item-meta mb-3">
                                            <i class="bi bi-calendar3"></i>
                                            Lost on {{ \Carbon\Carbon::parse($item->lost_date)->format('M d, Y') }}
                                        </div>

                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-details w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                                <i class="bi bi-eye me-1"></i> View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Detail Modal --}}
                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 12px; border: none;">
                                        <div class="modal-header" style="background: var(--findit-dark); color: #fff; border-radius: 12px 12px 0 0;">
                                            <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">{{ $item->title }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p>{{ $item->description }}</p>
                                            <hr>
                                            <p class="mb-1"><strong>Category:</strong> {{ $item->category_name }}</p>
                                            <p class="mb-1"><strong>Status:</strong> {{ $item->status }}</p>
                                            <p class="mb-1"><strong>Location:</strong> {{ $item->location }}</p>
                                            <p class="mb-0"><strong>Date Lost:</strong> {{ \Carbon\Carbon::parse($item->lost_date)->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
