<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property bool published
 */
class Post extends Model
{
    protected $fillable = ['title', 'content', 'published', 'publication_date'];
    public static $filterable = ['title', 'content', 'published', 'id','publication_date'];


    public function togglePublished()
    {
        $this->published == true ? $this->published = false : $this->published = true;
        $this->save();
        return $this->published ? 'Activated' : 'Deactivated';
    }


    function tags(){
        return $this->belongsToMany(Tag::class);
    }

    function comment(){
        return $this->hasMany(Comment::class);
    }

}
