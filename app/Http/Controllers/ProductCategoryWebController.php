<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryWebController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')
            ->paginate(50)
            ->withQueryString();

        return Inertia::render('product-categories/Index', [
            'categories' => $categories,
            'urls' => [
                'create' => route('product_categories.create'),
                'store' => route('product_categories.store'),
                'edit' => fn($id) => route('product_categories.edit', $id),
                'destroy' => fn($id) => route('product_categories.destroy', $id),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('product-categories/Form', [
            'category' => null,
            'urls' => [
                'store' => route('product_categories.store'),
                'index' => route('product_categories.index'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        ProductCategory::create($validated);

        return redirect('/product-categories')->with('success', 'Category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        return Inertia::render('product-categories/Form', [
            'category' => $productCategory,
            'urls' => [
                'update' => route('product_categories.update', $productCategory),
                'index' => route('product_categories.index'),
            ],
        ]);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $productCategory->update($validated);

        return redirect('/product-categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with existing products.']);
        }

        $productCategory->delete();

        return redirect('/product-categories')->with('success', 'Category deleted successfully.');
    }
}
