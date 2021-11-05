<?php

namespace App\Models;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model implements AttachableInterface
{
    use PaperclipTrait;

    protected $fillable = ['name' , 'link'];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('image', []);
        parent::__construct($attributes);
    }


}
