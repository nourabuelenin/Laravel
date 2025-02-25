<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:150|regex:/^[A-Za-z\s]+$/|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $categoryData = $request->except('image');
        //check if request has image
        if($request->hasFile('image')){
            //get extension of requested image
            //generate category image name by time function   
            $imgName = time(). '.' . $request->image->getClientOriginalExtension();

            //store image in storage/app/public
            try{
                $imagePath = $request->image->storeAs('category_images', $imgName, 'public');
                $categoryData['image'] = 'storage/' . $imagePath;
            }
            catch(\Exception $e){
                return back()->with('error', 'Failed to upload image.');
            }
        } else {
            $categoryData['image'] =  null;
        }
        //create category 
        $categoryData['slug'] = strtolower(str_replace(' ', '_', $categoryData['name']));
        Category::created($categoryData);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
