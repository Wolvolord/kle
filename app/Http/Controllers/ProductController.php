<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->latest()->get();

        return view('home', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        session()->flash('success', 'Ürün başarıyla eklendi.');
        return redirect('/');
    }

    public function show(string $id)
    {
        $product = Product::with('user')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $product->update($validated);

        session()->flash('success', 'Ürün başarıyla güncellendi.');
        return redirect('/products/' . $product->id);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Ürün başarıyla silindi.');
        return redirect('/');
    }
}
