<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // DB::table('categories')->dba_insert([]); //old method, better to use eloquent
        $categories = Category::all();
        return view();
    }
}
