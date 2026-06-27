@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                @if ($foundItem->image)
                    <img src="{{ asset('storage/' . $foundItem->image) }}" class="img-fluid" alt="{{ $foundItem->title }}" style="max-height: 420px; width: 100%; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 320px;">
                        <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $foundItem->title }}</h2>
                            <p class="text-muted mb-0">Reported by {{ $foundItem->user->name }}</p>
                        </div>
                        <span class="badge" style="background: var(--findit-primary);">{{ $foundItem->status }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-semibold">Description</h5>
                        <p class="text-muted mb-0">{{ $foundItem->description }}</p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Found at</small>
                                <strong>{{ $foundItem->location }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Date Found</small>
                                <strong>{{ $foundItem->found_date->format('F d, Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <a href="{{ route('claims.create', ['found_id' => $foundItem->id]) }}" class="btn btn-findit me-2">
                            <i class="bi bi-hand-thumbs-up me-2"></i>Claim This Item
                        </a>
                        <a href="{{ route('found-items.index') }}" class="btn btn-light">Back to List</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Item Details</h5>
                    <div class="mb-3">
                        <small class="text-muted d-block">Category</small>
                        <strong>{{ $foundItem->category->category_name }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Reported by</small>
                        <strong>{{ $foundItem->user->name }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Contact</small>
                        <strong>{{ $foundItem->user->phone }}</strong>
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
