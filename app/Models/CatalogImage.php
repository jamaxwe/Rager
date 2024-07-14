<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'image_path',
    ];
}
