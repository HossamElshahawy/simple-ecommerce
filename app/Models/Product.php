<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'summary',
        'image',
        'price',
        'offer_price',
        'discount',
        'quantity',
        'status',
        'category_id',
        'user_id',
    ];

    public function presentPrice(){
        return number_format($this->price, 1); // 2 decimal places
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the "creating" event and generate the slug
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
        // Listen for the "updating" event and update the slug if the "name" field is changed
        static::updating(function ($product) {
            // Check if the "name" attribute is dirty (has changed)
            if ($product->isDirty('name')) {
                // Generate a new slug based on the updated "name" value
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
