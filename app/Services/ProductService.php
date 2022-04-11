<?php


namespace App\Services;


use App\Models\Category;
use App\Models\Product;

class ProductService
{

    public function getByID($id){
        return Product::findOrFail($id);
    }

    public function create($data){
        $product = Product::create($data);
        $product->categories()->sync($data['categories']);
        return $product;
    }

    public function update($product, $data){
        $product->update($data);
        $product->categories()->sync($data['categories']);
        return $product;
    }

    public function delete($id){
        Product::destroy($id);
    }

    public function filter($request){
        $title = $request->filled('title') ? $request->query('title') : null;
        $publish = $request->filled('publish') ? (boolean)$request->query('publish') : null;
        $from = $request->filled('from') ? $request->query('from') : 0;
        $to = $request->filled('to') ? $request->query('to') : 0;
        $category = $request->filled('category') ? $request->query('category') : 0;
        $not_deleted = $request->filled('not_deleted') ? (boolean)$request->query('not_deleted') : 0;
        $category_name = 0;
        if($request->filled('category_name')){
            $cat = Category::where('name', 'LIKE', "%{$request->query('category_name')}%")->first();
            if($cat){
                $category_name = $cat->id;
            }
        }

        return Product::when(!is_null($title), function($query) use ($title){
            return $query->where('title', 'LIKE', "%{$title}%");
        })->when(!is_null($title), function($query) use ($publish){
            return $query->where('publish', $publish);
        })->when($from, function($query) use ($from){
            return $query->where('price', '>=', $from);
        })->when($to, function($query) use ($to){
            return $query->where('price', '<=', $to);
        })->when(!$not_deleted, function($query) use ($not_deleted){
            return $query->withTrashed();
        })->when($category, function($query) use ($category){
            return $query->whereHas('categories', function ($query) use ($category) {
                return $query->where('category_id', $category);
            });
        })->when($category_name, function($query) use ($category_name){
            return $query->whereHas('categories', function ($query) use ($category_name) {
                return $query->where('category_id', $category_name);
            });
        })->get();
    }
}
