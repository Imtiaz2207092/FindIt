@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px; margin-bottom: 20px;">
                @if ($lostItem->image)
                    <img src="{{ asset('storage/' . $lostItem->image) }}" class="card-img-top" alt="{{ $lostItem->title }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <div class="card-body">
                    <div class="mb-3">
                        <h2 class="card-title">{{ $lostItem->title }}</h2>
                        <div>
                            <span class="badge bg-warning text-dark me-2">{{ $lostItem->category->category_name }}</span>
                            <span class="badge" style="background: var(--findit-primary);">{{ $lostItem->status }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $lostItem->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong><i class="bi bi-geo-alt me-2"></i>Location:</strong>
                            <p>{{ $lostItem->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-calendar me-2"></i>Date Lost:</strong>
                            <p>{{ $lostItem->lost_date->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <strong><i class="bi bi-person-circle me-2"></i>Reported By:</strong>
                        <p>{{ $lostItem->user->name }} ({{ $lostItem->user->phone }})</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body">
                    <h5 class="mb-3">Is this your item?</h5>
                    <p class="text-muted small mb-3">If you found or have information about this item, please submit a claim.</p>
                    <a href="{{ route('claims.create', ['lost_id' => $lostItem->id]) }}" class="btn btn-findit me-2">
                        <i class="bi bi-hand-thumbs-up me-2"></i>Submit a Claim
                    </a>
                    <a href="{{ route('lost-items.index') }}" class="btn btn-light">Back to List</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);">
                <div class="card-body">
                    <h6 class="mb-3">Quick Stats</h6>
                    <div class="mb-2">
                        <small class="text-muted">Status</small>
                        <p class="mb-0"><strong>{{ $lostItem->status }}</strong></p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Category</small>
                        <p class="mb-0"><strong>{{ $lostItem->category->category_name }}</strong></p>
                    </div>
                    <div>
                        <small class="text-muted">Claims</small>
                        <p class="mb-0"><strong>{{ $lostItem->claims->count() }} claim(s)</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
