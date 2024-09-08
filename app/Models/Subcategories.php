<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subcategories extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'product_subcategory');
    }

}
