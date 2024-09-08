<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function getRouteKey(): mixed
    {
        return $this->slug;
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategories::class, 'category_id');
    }

}
