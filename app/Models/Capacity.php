<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    use HasFactory;
    protected $table = 'capacities';
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'map_products_capacity');
    }
}
