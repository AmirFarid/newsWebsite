<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Post(){
        return $this->hasMany(Post::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class);
    }

    public function child(){
        return $this->hasMany(Category::class);
    }

}
