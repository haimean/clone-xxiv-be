<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'image_uuid',
        "tile",
        "content",
        "description",
        "brand_id",
        'time_smell',
        'sex',
        'age',
        'spring',
        'summer',
        'fall',
        'winter',
        'day',
        'night',
        "published_at",
    ];
}
