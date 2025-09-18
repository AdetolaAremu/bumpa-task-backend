<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Services\ProductService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseHandler;

    //show all products
    public function getAllProducts(PaginationRequest $request, ProductService $productService)
    {
        $getProducts = $productService->getAllProducts($request);

        return $this->successResponse('Products retrieved successfully', $getProducts);
    }

    // show one product
    public function getOneProduct($slug, ProductService $productService)
    {
        $getProduct = $productService->getProductBySlug($slug);

        if (!$getProduct) return $this->errorResponse('Product not found', 404);

        return $this->successResponse('Product retrieved successfully', $getProduct);
    }
}
