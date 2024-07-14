<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = ['title', 'date']; // Remove 'image_path' if not managed directly

    public function images()
    {
        return $this->hasMany(CatalogImage::class);
    }
}
