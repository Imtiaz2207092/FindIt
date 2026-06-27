<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FoundItemController extends Controller
{
    public function index(): View
    {
        $foundItems = FoundItem::with('user', 'category')
            ->orderBy('found_date', 'desc')
            ->paginate(10);

        return view('items.found.index', compact('foundItems'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('items.found.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'not_in:0',
                'exists:categories,id',
            ],
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:4000'],
            'location' => ['required', 'string', 'max:100'],
            'found_date' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = 'Found';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('found-items', 'public');
            $validated['image'] = $path;
        }

        FoundItem::create($validated);

        return redirect()->route('found-items.index')
            ->with('success', 'Found item reported successfully!');
    }

    public function show(FoundItem $foundItem): View
    {
        return view('items.found.show', compact('foundItem'));
    }

    public function edit(FoundItem $foundItem): View
    {
        if ($foundItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('items.found.edit', compact('foundItem', 'categories'));
    }

    public function update(Request $request, FoundItem $foundItem): RedirectResponse
    {
        if ($foundItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:4000'],
            'location' => ['required', 'string', 'max:100'],
            'found_date' => ['required', 'date'],
            'status' => ['required', 'in:Found,Claimed,Returned'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('found-items', 'public');
            $validated['image'] = $path;
        }

        $foundItem->update($validated);

        return redirect()->route('found-items.show', $foundItem)
            ->with('success', 'Found item updated successfully!');
    }

    public function destroy(FoundItem $foundItem): RedirectResponse
    {
        if ($foundItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $foundItem->delete();

        return redirect()->route('found-items.index')
            ->with('success', 'Found item deleted successfully!');
    }
}
