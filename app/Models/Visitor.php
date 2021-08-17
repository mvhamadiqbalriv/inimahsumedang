<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    
    public static function createViewLog($post) {
        $postViews= new Visitor();
        $postViews->ip_address = \Request::getClientIp();
        $postViews->user_agent = \Request::header('User-Agent');
        $postViews->article = $post->id;
        $postViews->save();//please note to save it at lease, very important
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article');
    }

    
}
