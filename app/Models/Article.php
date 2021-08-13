<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
    use HasFactory;
    
    protected $table = 'articles';
    protected $fillable = [
        'judul', 'slug', 'gambar', 'konten', 'tag', 'category', 'creator', 'is_publish', 'selected_article'
    ];

    public function categories()
    {
        return $this->belongsTo(Category_article::class,'category');
    }

    public function creators()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article');
    }

    public function nutritions()
    {
        return DB::table('articles')->where('category',$this->id);
    }

}
