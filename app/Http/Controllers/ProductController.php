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
        $validated['product_code'] = $this->generateProductCode();

        Product::create($validated);

        session()->flash('success', 'Ürün başarıyla eklendi.');
        return redirect('/');
    }

    public function show(string $id)
    {
        $product = Product::with('user')
            ->where('product_code', $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = $this->findProduct($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = $this->findProduct($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $product->update($validated);

        session()->flash('success', 'Ürün başarıyla güncellendi.');
        return redirect('/products/' . $product->product_code);
    }

    public function destroy(string $id)
    {
        $product = $this->findProduct($id);
        $product->delete();

        session()->flash('success', 'Ürün başarıyla silindi.');
        return redirect('/');
    }

    private function findProduct(string $identifier): Product
    {
        return Product::where('product_code', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();
    }

    private function generateProductCode(): string
    {
        do {
            $code = (string) random_int(1, 9);
            for ($i = 0; $i < 18; $i++) {
                $code .= random_int(0, 9);
            }
        } while (Product::where('product_code', $code)->exists());

        return $code;
    }
}
