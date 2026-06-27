@extends('layouts.app')

@section('title', 'Welcome')

@section('styles')
<style>
    .hero-panel {
        background: linear-gradient(135deg, #071120 0%, #13294d 45%, #1d3f72 100%);
        position: relative;
        overflow: hidden;
        min-height: 420px;
    }
    .hero-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(255,90,31,0.24), transparent 32%);
        pointer-events: none;
    }
    .hero-panel .glass-card {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.16);
        backdrop-filter: blur(10px);
        border-radius: 22px;
    }
    .stat-tile {
        border-radius: 16px;
        padding: 14px;
        background: rgba(255,255,255,0.14);
        min-height: 92px;
    }
    .feature-tile {
        border-radius: 18px;
        padding: 22px;
        background: white;
        height: 100%;
        box-shadow: 0 16px 42px rgba(15,23,42,0.07);
    }
    .feature-icon {
        width: 46px;
        height: 46px;
        display: inline-grid;
        place-items: center;
        border-radius: 14px;
        background: rgba(255,90,31,0.12);
        color: var(--findit-primary);
        font-size: 1.15rem;
    }
    .step-card {
        border-radius: 18px;
        padding: 20px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid #e8eef8;
        height: 100%;
    }
    .action-link {
        padding: 12px 14px;
        border-radius: 14px;
        background: #f5f8ff;
        color: #14213d;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .action-link:hover { background: #eaf1ff; color: #14213d; }
    .filter-panel { display: none; }
    .filter-panel.active { display: block; }
    .item-scroll { max-height: 640px; overflow-y: auto; padding-right: 10px; }
    .btn-group .btn.active { background: var(--findit-primary); border-color: var(--findit-primary); color: #fff; }
    .badge-soft {
        background: rgba(255,255,255,0.16);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 999px;
        padding: 8px 12px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
</style>
@endsection

@section('content')
<div class="container py-2">
    @if (session('success'))
        <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
    @endif

    <section class="hero-panel rounded-4 p-4 p-lg-5 text-white">
        <div class="position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge-soft mb-3 d-inline-block">Premium campus recovery</span>
                    <h1 class="display-5 fw-bold mb-3">Recover what matters with a refined lost-and-found experience.</h1>
                    <p class="lead text-white-50 mb-4">FindIt brings student and staff reporting, claim review, and secure recovery into one polished platform.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('lost-items.create') }}" class="btn btn-findit">Report a Lost Item</a>
                        <a href="{{ route('found-items.index') }}" class="btn btn-outline-light-soft">Browse Found Items</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="text-uppercase small text-white-50">Today on campus</div>
                                <h4 class="mb-0">Live recovery activity</h4>
                            </div>
                            <span class="badge bg-white text-dark">Live</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-tile">
                                    <div class="fw-bold fs-4">{{ $activeReports ?? 0 }}</div>
                                    <div class="small text-white-50">Active reports</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-tile">
                                    <div class="fw-bold fs-4">{{ $reviewedClaims ?? 0 }}</div>
                                    <div class="small text-white-50">Claims reviewed</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-tile">
                                    <div class="fw-bold fs-4">{{ $approvedClaims ?? 0 }}</div>
                                    <div class="small text-white-50">Items reunited</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-tile">
                                    <div class="fw-bold fs-4">{{ $secureHandling ?? 100 }}%</div>
                                    <div class="small text-white-50">Secure handling</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="feature-tile">
                <div class="feature-icon mb-3"><i class="bi bi-search-heart"></i></div>
                <h5 class="fw-bold">Report lost belongings</h5>
                <p class="text-muted mb-0">Post bags, electronics, IDs, books, and other essentials with details and photos.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-tile">
                <div class="feature-icon mb-3"><i class="bi bi-shield-check"></i></div>
                <h5 class="fw-bold">Submit secure claims</h5>
                <p class="text-muted mb-0">Route each claim through a clear workflow so admins and owners stay aligned.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-tile">
                <div class="feature-icon mb-3"><i class="bi bi-bell-fill"></i></div>
                <h5 class="fw-bold">Stay notified instantly</h5>
                <p class="text-muted mb-0">Receive updates when matches, claims, or approvals happen in real time.</p>
            </div>
        </div>
    </section>

    <section class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card p-4">
                <h4 class="fw-bold mb-3">How it works</h4>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="fw-bold mb-2">1. Post</div>
                            <p class="small text-muted mb-0">Create a lost or found item entry with location and description.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="fw-bold mb-2">2. Match</div>
                            <p class="small text-muted mb-0">Review listings and identify potential matches quickly through the platform.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="fw-bold mb-2">3. Recover</div>
                            <p class="small text-muted mb-0">Open a claim, approve it, and bring belongings back to their owners.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Quick actions</h5>
                <a href="{{ route('lost-items.index') }}" class="action-link">
                    <span>View lost items</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('found-items.index') }}" class="action-link">
                    <span>View found items</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('claims.index') }}" class="action-link">
                    <span>Open claims</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('notifications.index') }}" class="action-link">
                    <span>Notifications</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <div class="small text-muted mt-3">Signed in as <strong>{{ auth()->user()->email }}</strong></div>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-3">
            <div>
                <h4 class="fw-bold mb-1">Browse current reports</h4>
                <p class="text-muted mb-0">Select Lost or Found to scroll through all active listings on campus.</p>
            </div>
            <div class="btn-group" role="group" aria-label="Item filter">
                <button type="button" class="btn btn-outline-secondary active" data-target="lost-panel">Lost Items</button>
                <button type="button" class="btn btn-outline-secondary" data-target="found-panel">Found Items</button>
            </div>
        </div>

        <div class="item-filter-panels">
            <div id="lost-panel" class="filter-panel active">
                <div class="item-scroll">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @forelse ($lostItems as $item)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 18px;">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 210px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 210px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fs-6 mb-0">{{ $item->title }}</h5>
                                            <span class="badge" style="background: var(--findit-primary);">{{ $item->status }}</span>
                                        </div>
                                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($item->description, 80) }}</p>
                                        <div class="mb-2">
                                            <span class="badge bg-warning text-dark">{{ $item->category->category_name }}</span>
                                        </div>
                                        <small class="text-muted d-block mb-2">
                                            <i class="bi bi-geo-alt"></i> {{ $item->location }}<br>
                                            <i class="bi bi-calendar"></i> {{ $item->lost_date->format('M d, Y') }}
                                        </small>
                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ route('lost-items.show', $item) }}" class="btn btn-sm btn-findit">Details</a>
                                            <a href="{{ route('claims.create', ['lost_id' => $item->id]) }}" class="btn btn-sm btn-light border">Claim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 rounded-4 border border-dashed bg-white">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-3 mb-0">No lost items currently available.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="found-panel" class="filter-panel">
                <div class="item-scroll">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @forelse ($foundItems as $item)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 18px;">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 210px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 210px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fs-6 mb-0">{{ $item->title }}</h5>
                                            <span class="badge" style="background: var(--findit-primary);">{{ $item->status }}</span>
                                        </div>
                                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($item->description, 80) }}</p>
                                        <div class="mb-2">
                                            <span class="badge bg-info text-dark">{{ $item->category->category_name }}</span>
                                        </div>
                                        <small class="text-muted d-block mb-2">
                                            <i class="bi bi-geo-alt"></i> {{ $item->location }}<br>
                                            <i class="bi bi-calendar"></i> {{ $item->found_date->format('M d, Y') }}
                                        </small>
                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ route('found-items.show', $item) }}" class="btn btn-sm btn-findit">Details</a>
                                            <a href="{{ route('claims.create', ['found_id' => $item->id]) }}" class="btn btn-sm btn-light border">Claim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 rounded-4 border border-dashed bg-white">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-3 mb-0">No found items currently available.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-target]').forEach(function(button) {
            button.addEventListener('click', function () {
                document.querySelectorAll('.filter-panel').forEach(function(panel) {
                    panel.classList.remove('active');
                });
                document.querySelectorAll('[data-target]').forEach(function(btn) {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                document.getElementById(button.dataset.target).classList.add('active');
            });
        });
    });
</script>
@endsection
