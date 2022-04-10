<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'price',
        'publish',
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }
}
