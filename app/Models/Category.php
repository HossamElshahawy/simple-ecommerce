<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','slug','status'];

    protected static function boot()
    {
        parent::boot();

        // Listen for the "creating" event and generate the slug
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
        // Listen for the "updating" event and update the slug if the "name" field is changed
        static::updating(function ($category) {
            // Check if the "name" attribute is dirty (has changed)
            if ($category->isDirty('name')) {
                // Generate a new slug based on the updated "name" value
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
