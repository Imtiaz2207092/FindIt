<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('welcome')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/welcome', function () {
        $lostItems = LostItem::where('status', '!=', 'Claimed')
            ->with('category', 'user')
            ->orderBy('lost_date', 'desc')
            ->get();

        $foundItems = FoundItem::where('status', '!=', 'Claimed')
            ->with('category', 'user')
            ->orderBy('found_date', 'desc')
            ->get();

        $activeReports = $lostItems->count() + $foundItems->count();
        $reviewedClaims = Claim::where('status', '!=', 'Pending')->count();
        $approvedClaims = Claim::where('status', 'Approved')->count();
        $totalClaims = Claim::count();
        $secureHandling = $totalClaims > 0
            ? round(($reviewedClaims / $totalClaims) * 100)
            : 100;

        return view('welcome', compact(
            'lostItems',
            'foundItems',
            'activeReports',
            'reviewedClaims',
            'approvedClaims',
            'secureHandling'
        ));
    })->name('welcome');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Lost Items
    Route::resource('lost-items', LostItemController::class);

    // Found Items
    Route::resource('found-items', FoundItemController::class);

    // Claims
    Route::resource('claims', ClaimController::class);
    Route::post('/claims/{claim}/approve', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Admin Routes
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });
});
