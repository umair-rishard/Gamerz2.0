<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // allow mass-assigning image_path
    protected $fillable = [
        'name',
        'description',
        'status',
        'image_path',
    ];

    //  make sure status is stored/returned as boolean
    protected $casts = [
        'status' => 'boolean',
    ];

    // (optional) relation used by withCount('products')
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
