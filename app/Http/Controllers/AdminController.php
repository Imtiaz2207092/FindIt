<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role !== 'Admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_lost_items' => LostItem::count(),
            'total_found_items' => FoundItem::count(),
            'pending_claims' => Claim::where('status', 'Pending')->count(),
            'approved_claims' => Claim::where('status', 'Approved')->count(),
        ];

        $recentClaims = Claim::with('user', 'lostItem', 'foundItem')
            ->orderBy('claim_date', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentClaims'));
    }

    public function users(): View
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function categories(): View
    {
        $categories = \App\Models\Category::withCount(['lostItems', 'foundItems'])->paginate(20);
        return view('admin.categories', compact('categories'));
    }

    public function reports(): View
    {
        $lostItemsByCategory = LostItem::select('categories.category_name', \DB::raw('count(*) as count'))
            ->join('categories', 'lost_items.category_id', '=', 'categories.id')
            ->groupBy('categories.category_name')
            ->get();

        $foundItemsByCategory = FoundItem::select('categories.category_name', \DB::raw('count(*) as count'))
            ->join('categories', 'found_items.category_id', '=', 'categories.id')
            ->groupBy('categories.category_name')
            ->get();

        return view('admin.reports', compact('lostItemsByCategory', 'foundItemsByCategory'));
    }
}
