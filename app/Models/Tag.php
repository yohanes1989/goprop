<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['title', 'slug'];
}
