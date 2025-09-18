<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->hasMany(ProductCategory::class, 'id', 'product_category_id');
    }
}
