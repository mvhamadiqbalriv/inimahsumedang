<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = "comment_replies";

    protected $fillable = [
        'nama', 'reply', 'email', 'web' , 'comment', 'status'
    ];
    
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
