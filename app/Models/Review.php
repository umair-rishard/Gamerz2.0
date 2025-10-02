<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_avatar',   // ✅ store the reviewer’s avatar URL
        'product_id',
        'rating',
        'comment',
        'created_at',
        'updated_at',
    ];

    // (Optional) helpful casts
    protected $casts = [
        'user_id'    => 'integer',
        'product_id' => 'integer',
        'rating'     => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
