@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Submit Item Claim</h2>
            <p class="text-muted">Report your connection to a lost or found item</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('claims.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-600">Select Item to Claim</label>
                            <div class="alert alert-info small mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                Select either a Lost item (if you found it) or a Found item (if it's yours).
                            </div>

                            <div class="mb-3">
                                <label for="lost_id" class="form-label">Lost Items</label>
                                <select name="lost_id" id="lost_id" class="form-select">
                                    <option value="">-- Or select a Lost item --</option>
                                    @foreach ($lostItems as $item)
                                        <option value="{{ $item->id }}" {{ (string) old('lost_id', $selectedLostId ?? '') === (string) $item->id ? 'selected' : '' }}>
                                            {{ $item->title }} ({{ $item->location }}) - {{ $item->lost_date->format('M d') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="found_id" class="form-label">Found Items</label>
                                <select name="found_id" id="found_id" class="form-select">
                                    <option value="">-- Or select a Found item --</option>
                                    @foreach ($foundItems as $item)
                                        <option value="{{ $item->id }}" {{ (string) old('found_id', $selectedFoundId ?? '') === (string) $item->id ? 'selected' : '' }}>
                                            {{ $item->title }} ({{ $item->location }}) - {{ $item->found_date->format('M d') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="proof_details" class="form-label fw-600">Proof Details</label>
                            <p class="text-muted small">Provide evidence or details proving your connection to this item (e.g., serial number, distinctive features, etc.)</p>
                            <textarea name="proof_details" id="proof_details" class="form-control @error('proof_details') is-invalid @enderror" 
                                      rows="5" placeholder="Describe specific details that prove this is your item or that you found it..." required>{{ old('proof_details') }}</textarea>
                            @error('proof_details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-findit py-2">
                                <i class="bi bi-check-circle me-2"></i>Submit Claim
                            </button>
                            <a href="{{ route('claims.index') }}" class="btn btn-light py-2">Cancel</a>
                        </div>
                    </form>
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
    .form-label { color: var(--findit-dark); font-weight: 500; }
</style>
@endsection
