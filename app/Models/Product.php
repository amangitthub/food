<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductImage;
class Product extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'product_type',
        'combo_product_ids',
        'short_description',
        'description',
        'price',
        'status',
    ];


    /**
     * Attribute Casting
     */
    protected $casts = [
        'combo_product_ids' => 'array',
        'price' => 'decimal:2',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}