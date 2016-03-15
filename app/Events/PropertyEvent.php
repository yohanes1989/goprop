<?php

namespace GoProp\Events;

use Illuminate\Queue\SerializesModels;

class PropertyEvent extends Event
{
    use SerializesModels;

    public $property;
    public $type;

    public function __construct($property, $type)
    {
        $this->property = $property;
        $this->type = $type;
    }
}