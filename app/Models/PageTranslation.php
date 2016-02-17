<?php

namespace GoProp\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;

class PageTranslation extends Model implements SluggableInterface
{
    use SluggableTrait;

    public $timestamps = FALSE;

    protected $guarded = ['identifier'];
    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
        'on_update' => TRUE
    ];
}
