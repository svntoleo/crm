<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductWebController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(50)->withQueryString();
        $categories = ProductCategory::orderBy('label')->get();

        return Inertia::render('products/Index', [
            'products' => $products,
            'categories' => $categories,
            'urls' => [
                'create' => route('products.create'),
                'store' => route('products.store'),
            ],
        ]);
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('label')->get();

        return Inertia::render('products/Form', [
            'product' => null,
            'categories' => $categories,
            'urls' => [
                'store' => route('products.store'),
                'index' => route('products.index'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('label')->get();

        return Inertia::render('products/Form', [
            'product' => $product,
            'categories' => $categories,
            'urls' => [
                'update' => route('products.update', $product),
                'index' => route('products.index'),
            ],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
