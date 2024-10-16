<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'product',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }
}
