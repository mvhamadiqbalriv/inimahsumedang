<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_article extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'slug'
    ];

    public function Article()
    {
        return $this->hasMany(Article::class);
    }
}
