<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'price'       => 'required|numeric|min:0.01|max:10000000',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required'        => 'Ürün adı zorunludur.',
            'name.max'             => 'Ürün adı en fazla 255 karakter olabilir.',
            'price.required'       => 'Ürün fiyatı zorunludur.',
            'price.numeric'        => 'Ürün fiyatı geçerli bir sayı olmalıdır.',
            'price.min'            => 'Ürün fiyatı en az 0,01 ₺ olmalıdır.',
            'price.max'            => 'Ürün fiyatı en fazla 10.000.000 ₺ olabilir.',
            'description.required' => 'Ürün açıklaması zorunludur.',
            'image.image'          => 'Yüklenen dosya geçerli bir görsel olmalıdır.',
            'image.mimes'          => 'Görsel formatı jpeg, png, jpg veya webp olmalıdır.',
            'image.max'            => 'Görsel boyutu en fazla 2 MB olabilir.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['product_code'] = $this->generateProductCode();

        try {
            $newProduct = Product::create($validated);
        } catch (\Throwable $e) {
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            throw $e;
        }

        ActivityLog::record(
            'create',
            "'{$newProduct->name}' ürünü sisteme eklendi.",
            'Product',
            $newProduct->id,
            $newProduct->name,
            [
                'price'        => $newProduct->price,
                'product_code' => $newProduct->product_code,
            ]
        );

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
            'price'       => 'required|numeric|min:0.01|max:10000000',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required'        => 'Ürün adı zorunludur.',
            'name.max'             => 'Ürün adı en fazla 255 karakter olabilir.',
            'price.required'       => 'Ürün fiyatı zorunludur.',
            'price.numeric'        => 'Ürün fiyatı geçerli bir sayı olmalıdır.',
            'price.min'            => 'Ürün fiyatı en az 0,01 ₺ olmalıdır.',
            'price.max'            => 'Ürün fiyatı en fazla 10.000.000 ₺ olabilir.',
            'description.required' => 'Ürün açıklaması zorunludur.',
            'image.image'          => 'Yüklenen dosya geçerli bir görsel olmalıdır.',
            'image.mimes'          => 'Görsel formatı jpeg, png, jpg veya webp olmalıdır.',
            'image.max'            => 'Görsel boyutu en fazla 2 MB olabilir.',
        ]);

        $oldValues = [
            'name'        => $product->name,
            'price'       => (string) $product->price,
            'description' => $product->description,
            'image'       => $product->image,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        $changes = [];
        foreach ($oldValues as $key => $oldVal) {
            $newVal = (string) $product->{$key};
            if ($newVal !== (string) $oldVal) {
                $changes[$key] = [
                    'old' => $key === 'image' ? ($oldVal ? 'Eski Görsel' : 'Görsel Yok') : $oldVal,
                    'new' => $key === 'image' ? 'Yeni Görsel' : $product->{$key},
                ];
            }
        }

        ActivityLog::record(
            'update',
            "'{$product->name}' ürünü güncellendi.",
            'Product',
            $product->id,
            $product->name,
            $changes
        );

        session()->flash('success', 'Ürün başarıyla güncellendi.');
        return redirect('/products/' . $product->product_code);
    }

    public function destroy(string $id)
    {
        $product = $this->findProduct($id);
        $productName = $product->name;
        $productId = $product->id;
        $productCode = $product->product_code;

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        ActivityLog::record(
            'delete',
            "'{$productName}' ürünü sistemden silindi.",
            'Product',
            $productId,
            $productName,
            [
                'product_code' => $productCode,
            ]
        );

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
