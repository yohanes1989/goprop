<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $guarded = [];

    public function saveData($data)
    {
        $this->data = serialize($data);
    }

    public function saveLabel($data)
    {
        $this->label = serialize($data);
    }
}
