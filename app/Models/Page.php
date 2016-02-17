<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Translatable;

    protected $fillable = ['identifier'];

    public $translatedAttributes = ['title', 'slug', 'content'];
}
