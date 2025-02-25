<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
    public function edit(Category $category)
    {
        $category = Category::find($category->id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:150|regex:/^[A-Za-z\s]+$/|unique:categories,name,' . $category->id,
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

                //delete old image
                $this->deleteOldImage($category);
            }
            catch(\Exception $e){
                return back()->with('error', 'Failed to upload image.');
            }
        } else {
            $categoryData['image'] =  null;
        }

        //generate a new slug
        $categoryData['slug'] = strtolower(str_replace(' ', '_', $categoryData['name']));

        //update category 
        $category->update($categoryData);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //delete old image
        $this->deleteOldImage($category);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    protected function deleteOldImage($category){
        //delete old image
        if($category->image){
            $oldImagePath = str_replace('storage/', '', $category->image);
            if(storage::disk('public')->exists($oldImagePath)){
                Storage::disk('public')->delete($oldImagePath);
            }
        };
    }
}
