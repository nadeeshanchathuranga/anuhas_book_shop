<?php

namespace App\Http\Controllers;

use App\Models\Printout;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printouts = Printout::latest()->paginate(12);
        
        return Inertia::render('Printouts/Index', [
            'printouts' => $printouts,
            'totalPrintouts' => Printout::count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Printouts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'default_quantity' => 'required|integer|min:1',
        ]);

        Printout::create($request->all());

        return redirect()->route('printouts.index')->with('success', 'Printout created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Printout $printout)
    {
        return Inertia::render('Printouts/Show', [
            'printout' => $printout,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Printout $printout)
    {
        return Inertia::render('Printouts/Edit', [
            'printout' => $printout,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Printout $printout)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'default_quantity' => 'required|integer|min:1',
        ]);

        $printout->update($request->all());

        return redirect()->route('printouts.index')->with('success', 'Printout updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Printout $printout)
    {
        $printout->delete();

        return redirect()->route('printouts.index')->with('success', 'Printout deleted successfully.');
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Printout $printout)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $printout->update([
            'stock_quantity' => $request->stock_quantity,
        ]);

        return back()->with('success', 'Stock quantity updated successfully.');
    }
    /**
 * API endpoint for fetching printouts (for POS modal)
 */
public function apiIndex(Request $request)
{
    $query = Printout::query();

    // Search
    if ($request->has('search') && $request->search) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Stock filter
    if ($request->has('stock') && $request->stock !== 'all') {
        if ($request->stock === 'in') {
            $query->where('stock_quantity', '>', 0);
        } elseif ($request->stock === 'out') {
            $query->where('stock_quantity', '<=', 0);
        }
    }

    // Price sort
    if ($request->has('sort')) {
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }
    } else {
        $query->latest();
    }

    $printouts = $query->paginate(12);

    return response()->json($printouts);
}
}