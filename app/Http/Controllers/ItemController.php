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
        // dd($request->all());

        $validatedData = $request->validate([
            'cat_id' => 'required',
            'item_name' => 'required',
            'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
            'qty' => 'required',
            'locations' => 'required',
        ], [
            'item_name.required' => 'The Name field is required.',
            'qty.required' => 'The Quantity field is required.',
            'locations.required' => 'The Location field is required.',
        ]);

        Item::create([
            'cat_id' => $request->cat_id,
            'item_name' => $request->item_name,
            'conditions' => $request->conditions,
            'qty' => $request->qty,
            'locations' => $request->locations,
        ]);

        return redirect('/item')->with('success', 'Item has been added');
    } 

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori
        return view('pages.items.edit', compact('item', 'categories'));
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
