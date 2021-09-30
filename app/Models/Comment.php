<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama', 'comment', 'email', 'web', 'article'
    ];

    protected $dates = ['deleted_at'];
    
    public function articless()
    {
        return $this->belongsTo(Article::class, 'article');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'comment');
    }
}
