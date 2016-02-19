<?php

namespace GoProp\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model implements SluggableInterface
{
    use SluggableTrait;

    public $timestamps = FALSE;

    protected $guarded = [];
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
        'on_update' => TRUE
    ];

    //Relations
    public function parent()
    {
        return $this->belongsTo('GoProp\Models\PropertyType', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('GoProp\Models\PropertyType', 'parent_id');
    }

    //Statics
    public static function getOptions()
    {
        $options = [];

        $parents = self::whereNull('parent_id')->orderBy('sort_order', 'ASC')->get();

        foreach($parents as $child){
            $options += self::processOption($child);
        }

        return $options;
    }

    private static function processOption($option)
    {
        $return = [];
        $children = $option->children;

        if(count($children) > 0){
            $return[$option->name] = [];

            foreach($children as $child){
                $return[$option->name] += self::processOption($child);
            }
        }else{
            $return[$option->id] = $option->name;
        }

        return $return;
    }
}
