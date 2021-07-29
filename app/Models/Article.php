<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    protected $table = 'articles';
    protected $fillable = [
        'judul', 'slug', 'gambar', 'konten', 'tag', 'category', 'creator', 'is_publish'
    ];

    public function categories()
    {
        return $this->belongsTo(Category_article::class,'category');
    }
}
