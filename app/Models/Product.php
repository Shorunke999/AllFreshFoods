<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'price',
        'stock',
        'image_path',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Scope a query to only include products for a given user.
     */
    public function scopeForUser($query, $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('vendor_id', $user->vendor->id);
    }
}
