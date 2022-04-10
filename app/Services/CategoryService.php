<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{

    public function getByID($id){
        return Category::findOrFail($id);
    }

    public function create($name){
        return Category::create(['name' => $name]);
    }

    public function update($category, $name){
        $category->update(['name' => $name]);
        return $category;
    }

    public function delete($id){
        $category = $this->getByID($id);
        $checkRelation = count($category->products);
        if(!$checkRelation){
            $category->delete();
        }
        return $checkRelation;
    }

}
