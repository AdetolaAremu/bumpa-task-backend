<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Traits\ResponseHandler;

class ProductService
{
    public function getAllProducts($request)
    {
        $searchQuery = strtolower($request->searchQuery ?? '');
        $perPage = $request->pageSize ?? 10;

        $products = Product::with('categoryProduct.category')
            ->where(function ($query) use ($searchQuery) {
                $query->whereRaw('LOWER(title) LIKE ?', ["%{$searchQuery}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchQuery}%"])
                    ->orWhereHas('categoryProduct.category', function ($q) use ($searchQuery) {
                        $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchQuery}%"]);
                    });
            })
            ->paginate($perPage);

        return $products;
    }

    public function getProductBySlug($slug)
    {
        return Product::where('slug', $slug)->with('categoryProduct.category')->first();
    }

    public function getProductById($id)
    {
        return Product::where('id', $id)->with('categoryProduct.category')->first();
    }
}
