<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:10|max:255|regex:/^[A-Za-z0-9\s]+$/|unique:products,name',
            'description' => 'nullable|string|min:10|max:255',
            'price' => 'required|numeric|',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'categories' => 'nullable|array'
        ]);

        $productData = $request->except(['image', 'categories']);
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            try {
                $imagePath = $request->image->storeAs('product_images', $imageName, 'public');
                $productData['image'] = 'storage/' . $imagePath;
            } catch (\Exception $e) {
                return back()->with('error', 'Image upload failed');
            }
        } else {
            $productData['image'] = null;
        }
        //make migration for unique slug to make this logic
        // $productData['slug'] = Hash::make(strtolower(str_replace(' ', '_', $productData['name'])));
        $productData['slug'] = Hash::make($request->slug);

        $product = Product::create($productData);
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:10|max:255|regex:/^[A-Za-z0-9\s]+$/|unique:products,name',
            'description' => 'nullable|string|min:10|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);
    
        $productData = $request->except(['image', 'categories']);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $imageName = time() . '.' . $extension;
            try {
                $imagePath = $request->image->storeAs('product_images', $imageName, 'public');
                $productData['image'] = 'storage/' . $imagePath;
    
                // Delete old image
                if ($product->image) {
                    $oldImagePath = str_replace('storage/', '', $product->image);
                    Storage::disk('public')->delete($oldImagePath);
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Image upload failed');
            }
        }
    
        // Update slug if name changes
        if ($productData['name'] != $product->name) {
            $productData['slug'] = strtolower(str_replace(' ', '-', $request->name));
        }    
        $product->update($productData);
    
        // Sync categories
        $product->categories()->sync($request->categories);
    
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete product image
        if ($product->image) {
            $oldImagePath = str_replace('storage/', '', $product->image);
            Storage::disk('public')->delete($oldImagePath);
        }
        $product->delete();
    
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}