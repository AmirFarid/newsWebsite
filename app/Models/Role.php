<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name'];

    const ADMIN = 'admin';
    const WRITER = 'writer';

    const ROLES = [
        self::ADMIN  => 'سرپرست',
        self::WRITER => 'نویسنده',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
