<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategories::class, 'product_subcategory', 'product_id');
    }

    public function getRouteKey(): mixed
    {
        return $this->slug;
    }
}
