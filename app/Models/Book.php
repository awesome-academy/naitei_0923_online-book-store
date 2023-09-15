<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'name',
        'description',
        'price',
        'publisher',
        'publisher_year',
        'author',
        'page_nums',
    ];

    public function categories()
    {
        return $this->BelongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
