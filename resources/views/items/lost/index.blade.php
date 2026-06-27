@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card p-4 mb-4 border-0" style="background: linear-gradient(135deg, #071120 0%, #13294d 100%); color: white;">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h2 class="fw-bold mb-1">Lost Items</h2>
                <p class="mb-0 text-white-50">University essentials, student belongings, and campus valuables — all in one secure place.</p>
            </div>
            <a href="{{ route('lost-items.create') }}" class="btn btn-findit px-4">
                <i class="bi bi-plus-circle me-2"></i>Report Lost Item
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($lostItems as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 18px;">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 250px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $item->title }}</h5>
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
                        <a href="{{ route('lost-items.show', $item) }}" class="btn btn-sm btn-findit mt-auto">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 rounded-4 border border-dashed bg-white">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3 mb-0">No lost items reported yet.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{ $lostItems->links() }}
</div>

<style>
    .btn-findit {
        background: var(--findit-primary);
        color: white;
        border: none;
        font-weight: 600;
    }
    .btn-findit:hover {
        background: #c92703;
        color: white;
    }
</style>
@endsection
