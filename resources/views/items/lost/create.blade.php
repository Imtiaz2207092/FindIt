@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Report Lost Item</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <form action="{{ route('lost-items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-600">Category</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-600">Item Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="e.g., Blue Samsung Wallet" required value="{{ old('title') }}">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-600">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" placeholder="Describe the item in detail..." required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label fw-600">Last Seen Location</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" 
                                   placeholder="e.g., KUET Campus, Main Gate" required value="{{ old('location') }}">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lost_date" class="form-label fw-600">Date Lost</label>
                            <input type="date" name="lost_date" id="lost_date" class="form-control @error('lost_date') is-invalid @enderror" required value="{{ old('lost_date') }}">
                            @error('lost_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-600">Photo (Optional)</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-findit py-2">
                                <i class="bi bi-send me-2"></i>Report Item
                            </button>
                            <a href="{{ route('lost-items.index') }}" class="btn btn-light py-2">Cancel</a>
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
