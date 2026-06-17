<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [

        'user_email',

        'title',

        'author',

        'publisher',

        'year',

        'cover'
    ];
}
