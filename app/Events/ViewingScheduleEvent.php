<?php

namespace GoProp\Events;

use Illuminate\Queue\SerializesModels;

class ViewingScheduleEvent extends Event
{
    use SerializesModels;

    public $viewingSchedule;
    public $type;

    public function __construct($viewingSchedule, $type)
    {
        $this->viewingSchedule = $viewingSchedule;
        $this->type = $type;
    }
}