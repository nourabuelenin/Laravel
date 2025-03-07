<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name','slug','description', 'price','stock', 'image'
    ];

    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
