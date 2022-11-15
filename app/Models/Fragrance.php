<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fragrance extends Model
{
    use HasFactory;
    protected $table = 'fragrances';
    protected $fillable = [
        'name',
        'description',
        'image_uuid',
    ];
}
