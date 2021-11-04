<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property bool active
 */
class Post extends Model
{
    protected $fillable = ['title', 'content', 'active', 'publication_date'];
    public static $filterable = ['title', 'content', 'active', 'id','publication_date'];


    public function toggleactive()
    {
        $this->active == true ? $this->active = false : $this->active = true;
        $this->save();
        return $this->active ? 'Activated' : 'Deactivated';
    }

    function Categories(){
        return $this->belongsTo(Category::class);
    }

    function tags(){
        return $this->belongsToMany(Tag::class);
    }

    function comments(){
        return $this->hasMany(Comment::class);
    }

    function multiMedias(){
        return $this->hasMany(Multimedia::class);
    }

}
