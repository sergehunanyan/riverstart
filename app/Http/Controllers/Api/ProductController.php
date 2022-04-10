<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts(Request $request){
        $products = $this->productService->filter($request);
        return response([
            'data' => [
                'products' => $products
            ],
            "success" => true,
        ], 200);
    }

    public function create(ProductRequest $request){
        $product = $this->productService->create($request->all());
        return response([
            'data' => [
                'product' => $product
            ],
            "success" => true,
        ], 200);
    }

    public function update(ProductRequest $request, $id){
        $product = $this->productService->getByID($id);
        $product = $this->productService->update($product, $request->all());
        return response([
            'data' => [
                'product' => $product
            ],
            "success" => true,
        ], 200);
    }

    public function delete($id){
        $this->productService->delete($id);
        return response([
            "success" => true,
        ], 200);
    }
}
