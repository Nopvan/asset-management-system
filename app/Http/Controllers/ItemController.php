<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->paginate(10);
        return view('pages.items.index',
            [
                'items' => $items
            ]);
    }

    public function create()
    {
        $categories = category::all(); // Ambil semua kategori
        return view('pages.items.create', compact('categories'));
    }


public function store(Request $request)
{
    // dd($request->file('photo'));
    $validatedData = $request->validate([
        'cat_id' => 'required',
        'item_name' => 'required',
        'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
        'qty' => 'required',
        'locations' => 'required',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('storage/uploads/items'), $filename);
        $path = 'uploads/items/' . $filename;
    }

    Item::create([
        'cat_id' => $request->cat_id,
        'item_name' => $request->item_name,
        'conditions' => $request->conditions,
        'qty' => $request->qty,
        'locations' => $request->locations,
        'photo' => $path ?? null, 
    ]);

    return redirect('/item')->with('success', 'Item has been added');
}

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori
        return view('pages.items.edit', compact('item', 'categories'));
    }
    
    public function show($id)
    {
        $item = Item::findOrFail($id);
        
        return view('pages.items.show', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cat_id' => 'required',
            'item_name' => 'required',
            'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
            'qty' => 'required',
            'locations' => 'required',
        ]);

        Item::findOrFail($id)->update($validatedData);
        return redirect('/item')->with('success', 'Item has been updated');
    }

    public function destroy($id)
    {
        $items = Item::find($id);
        $items->delete();

        return redirect('/item')->with('success', 'Item has been deleted');
    }

    public function exportPdf()
    {
        // Ambil semua data item, terus bagi jadi per 10 item
        $items = Item::with('category')->get()->chunk(10);

        // Kirim ke view PDF yang udah kita siapin
        $pdf = Pdf::loadView('pages.items.pdf', [
            'items' => $items
        ]);

        // Download hasil PDF-nya
        return $pdf->download('items.pdf');
    }

}
