<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // DB::table('categories')->dba_insert([]); //old method, better to use eloquent
        $categories = Category::all();
        return view();
    }
}
