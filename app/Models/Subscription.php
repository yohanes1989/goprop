<?php

namespace GoProp\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model implements SluggableInterface
{
    use SluggableTrait;

    public $timestamps = FALSE;

    protected $guarded = [];
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];
}
