<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemSearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = LostItem::query()
            ->join('categories', 'lost_items.category_id', '=', 'categories.id')
            ->select(
                'lost_items.*',
                'categories.category_name'
            );

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($builder) use ($search) {
                $builder->where('lost_items.title', 'like', "%{$search}%")
                    ->orWhere('lost_items.description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $categoryIds = (array) $request->input('category_id');
            $query->whereIn('lost_items.category_id', $categoryIds);
        }

        if ($request->filled('status')) {
            $statuses = (array) $request->input('status');
            $query->whereIn('lost_items.status', $statuses);
        }

        $items = $query->latest('lost_items.created_at')->get();
        $categories = Category::orderBy('category_name')->get();

        $statuses = ['Lost', 'Matched', 'Claimed', 'Returned'];

        return view('search', compact('items', 'categories', 'statuses'));
    }
}
