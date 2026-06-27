<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LostItemController extends Controller
{
    public function index(): View
    {
        $lostItems = LostItem::with('user', 'category')
            ->orderBy('lost_date', 'desc')
            ->paginate(10);

        return view('items.lost.index', compact('lostItems'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('items.lost.create', compact('categories'));
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
            'lost_date' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = 'Lost';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lost-items', 'public');
            $validated['image'] = $path;
        }

        LostItem::create($validated);

        return redirect()->route('lost-items.index')
            ->with('success', 'Lost item reported successfully!');
    }

    public function show(LostItem $lostItem): View
    {
        return view('items.lost.show', compact('lostItem'));
    }

    public function edit(LostItem $lostItem): View
    {
        if ($lostItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('items.lost.edit', compact('lostItem', 'categories'));
    }

    public function update(Request $request, LostItem $lostItem): RedirectResponse
    {
        if ($lostItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
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
            'lost_date' => ['required', 'date'],
            'status' => ['required', 'in:Lost,Found,Claimed'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lost-items', 'public');
            $validated['image'] = $path;
        }

        $lostItem->update($validated);

        return redirect()->route('lost-items.show', $lostItem)
            ->with('success', 'Lost item updated successfully!');
    }

    public function destroy(LostItem $lostItem): RedirectResponse
    {
        if ($lostItem->user_id !== auth()->user()->id && auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $lostItem->delete();

        return redirect()->route('lost-items.index')
            ->with('success', 'Lost item deleted successfully!');
    }
}
