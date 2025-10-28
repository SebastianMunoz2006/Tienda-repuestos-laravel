<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Añade esto

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'brand',
        'vehicle_type'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con comentarios
    public function comments(): HasMany
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function scopeSearch($query, $keywords)
    {
        return $query->where('name', 'like', "%{$keywords}%")
                    ->orWhere('description', 'like', "%{$keywords}%")
                    ->orWhere('brand', 'like', "%{$keywords}%");
    }
}