@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">System overview and management tools</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm" style="border-left: 4px solid var(--findit-primary);">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Users</h6>
                    <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm" style="border-left: 4px solid #28a745;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Lost Items</h6>
                    <h3 class="mb-0">{{ $stats['total_lost_items'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm" style="border-left: 4px solid #17a2b8;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Found Items</h6>
                    <h3 class="mb-0">{{ $stats['total_found_items'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card shadow-sm" style="border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Pending Claims</h6>
                    <h3 class="mb-0">{{ $stats['pending_claims'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Recent Claims</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Claim ID</th>
                                <th>User</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentClaims as $claim)
                                <tr>
                                    <td>#{{ $claim->claim_id }}</td>
                                    <td>{{ $claim->user->name }}</td>
                                    <td>
                                        @if ($claim->lostItem)
                                            {{ $claim->lostItem->title }} (Lost)
                                        @elseif ($claim->foundItem)
                                            {{ $claim->foundItem->title }} (Found)
                                        @endif
                                    </td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm" style="border-radius: 12px; background: var(--findit-bg);">
                <div class="card-body">
                    <h5 class="mb-3">Management</h5>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                        <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-list-ul me-2"></i>Manage Categories
                        </a>
                        <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-bar-chart me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --findit-primary: #e62e04;
        --findit-dark: #1a1a2e;
        --findit-bg: #f5f6fa;
    }
</style>
@endsection
