<?php

namespace App\Models;

use App\Helper\Api\Transformer\ApiTransformer;
use App\Helper\Api\Transformer\MultimediaTransformer;
use App\Services\Filter\FilterFacade;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property bool active
 */
class Post extends Model
{
    protected $fillable = ['title', 'content', 'active', 'publication_date'];
    public static $filterable = ['title', 'content', 'active', 'id','publication_date','mime_type'];


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

//    function getMedia(){
//
//        $medias = FilterFacade::filter(Multimedia::class,null,[
//            'search' => [
//                'post_id' => $this->id
//            ]
//        ]);
//
//        return ApiTransformer::transform(MultimediaTransformer::class, $medias->get());
//    }

    function multiMedias(){
        return $this->hasMany(Multimedia::class);
    }

}
