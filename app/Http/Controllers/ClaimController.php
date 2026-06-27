<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\LostItem;
use App\Models\FoundItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimController extends Controller
{
    public function index(): View
    {
        $claims = Claim::with('user', 'lostItem', 'foundItem')
            ->orderBy('claim_date', 'desc')
            ->paginate(10);

        return view('claims.index', compact('claims'));
    }

    public function create(Request $request): View
    {
        $lostItems = LostItem::where('status', '!=', 'Claimed')->get();
        $foundItems = FoundItem::where('status', '!=', 'Claimed')->get();
        $selectedLostId = $request->input('lost_id');
        $selectedFoundId = $request->input('found_id');

        return view('claims.create', compact('lostItems', 'foundItems', 'selectedLostId', 'selectedFoundId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lost_id' => ['nullable', 'exists:lost_items,id'],
            'found_id' => ['nullable', 'exists:found_items,id'],
            'proof_details' => ['required', 'string', 'max:4000'],
        ]);

        if (!$validated['lost_id'] && !$validated['found_id']) {
            return back()->withErrors(['error' => 'Please select either a Lost or Found item.']);
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = 'Pending';

        Claim::create($validated);

        return redirect()->route('claims.index')
            ->with('success', 'Claim submitted successfully! Admin will review shortly.');
    }

    public function show(Claim $claim): View
    {
        return view('claims.show', compact('claim'));
    }

    public function approve(Claim $claim): RedirectResponse
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $claim->update(['status' => 'Approved']);

        if ($claim->lost_id) {
            LostItem::find($claim->lost_id)->update(['status' => 'Claimed']);
        }
        if ($claim->found_id) {
            FoundItem::find($claim->found_id)->update(['status' => 'Claimed']);
        }

        return back()->with('success', 'Claim approved successfully!');
    }

    public function reject(Claim $claim): RedirectResponse
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403);
        }

        $claim->update(['status' => 'Rejected']);

        return back()->with('success', 'Claim rejected.');
    }
}
