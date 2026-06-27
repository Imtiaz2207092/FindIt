@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">My Claims</h2>
            <p class="text-muted">Track your item claims and their status</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('claims.create') }}" class="btn btn-findit">
                <i class="bi bi-plus-circle me-2"></i>New Claim
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Claim ID</th>
                        <th>Item</th>
                        <th>Item Type</th>
                        <th>Proof Details</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($claims as $claim)
                        <tr>
                            <td>#{{ $claim->claim_id }}</td>
                            <td>
                                @if ($claim->lostItem)
                                    <strong>{{ $claim->lostItem->title }}</strong>
                                @elseif ($claim->foundItem)
                                    <strong>{{ $claim->foundItem->title }}</strong>
                                @endif
                            </td>
                            <td>
                                @if ($claim->lostItem)
                                    <span class="badge bg-warning text-dark">Lost</span>
                                @elseif ($claim->foundItem)
                                    <span class="badge bg-info">Found</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($claim->proof_details, 50) }}</td>
                            <td>
                                <span class="badge 
                                    @if ($claim->status == 'Pending') bg-warning text-dark
                                    @elseif ($claim->status == 'Approved') bg-success
                                    @else bg-danger @endif">
                                    {{ $claim->status }}
                                </span>
                            </td>
                            <td>{{ $claim->claim_date->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('claims.show', $claim) }}" class="btn btn-sm btn-light">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No claims yet. <a href="{{ route('claims.create') }}">Submit your first claim</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $claims->links() }}
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
