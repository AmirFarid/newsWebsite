<?php

namespace App\Models;

use Czim\Paperclip\Contracts\AttachableInterface;
use Czim\Paperclip\Model\PaperclipTrait;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model implements AttachableInterface
{
    use PaperclipTrait;

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('media', []);
        parent::__construct($attributes);
    }


}
