<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property bool published
 */
class Post extends Model
{
    protected $fillable = ['title', 'content', 'published', 'publication_date'];
    public static $filterable = ['title', 'content', 'published', 'id'];


    public function togglePublished()
    {
        $this->published == true ? $this->published = false : $this->published = true;
        return $this->save();
    }


    function tags(){
        return $this->belongsToMany(Tag::class);
    }

}
