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
        ]);
    }

    public function create()
    {
        return Inertia::render('product-categories/Form', [
            'category' => null,
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
