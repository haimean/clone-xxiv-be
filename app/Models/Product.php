<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function brand()
    {
        return $this->hasOne(Brands::class, 'id');
    }
    public function capacities()
    {
        return $this->belongsToMany(Capacity::class, 'map_porducts_capacity', 'product_id', 'capacity_id')->withPivot('quantity', 'price');
    }

    public function main_scent()
    {
        return $this->belongsToMany(Fragrance::class, 'map_main_scent');
    }
    public function top_scent()
    {
        return $this->belongsToMany(Fragrance::class, 'map_top_scent');
    }
    public function middle_scent()
    {
        return $this->belongsToMany(Fragrance::class, 'map_middle_scent');
    }
    public function last_scent()
    {
        return $this->belongsToMany(Fragrance::class, 'map_last_scent');
    }
}
