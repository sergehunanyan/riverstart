<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CategoryRequest $request){
        $category = $this->categoryService->create($request->name);
        return response([
            'data' => [
                'category' => $category
            ],
            "success" => true,
        ], 200);
    }

    public function update(CategoryRequest $request, $id){
        $category = $this->categoryService->getByID($id);
        $category = $this->categoryService->update($category, $request->name);
        return response([
            'data' => [
                'category' => $category
            ],
            "success" => true,
        ], 200);
    }

    public function delete($id){
        $status = $this->categoryService->delete($id);
        return response([
            "success" => $status,
        ], 200);
    }
}
