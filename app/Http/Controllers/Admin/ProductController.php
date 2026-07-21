<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Manajemen Produk: List, Create, Update, Delete.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|file|max:2048',
            'material' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $ext = strtolower($request->image->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['image' => 'Harus berupa gambar (jpeg, png, jpg, gif).'])->withInput();
            }
            $imageName = time().'.'.$ext;
            $request->image->move(public_path('images/products'), $imageName);
            $data['img'] = '/images/products/'.$imageName;
        }

        Product::create($data);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $ext = strtolower($request->image->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['image' => 'Harus berupa gambar (jpeg, png, jpg, gif).'])->withInput();
            }
            $imageName = time().'.'.$ext;
            $request->image->move(public_path('images/products'), $imageName);
            $data['img'] = '/images/products/'.$imageName;
        }

        $product->update($data);

        return redirect('/admin/products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus.');
    }
}
