<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $guarded = [];

    private $_unserializedData;

    public function saveData($data)
    {
        $this->data = serialize($data);
    }

    public function saveLabel($data)
    {
        $this->label = serialize($data);
    }

    public function getData($key)
    {
        if(!isset($this->_unserializedData)){
            $unserialized = unserialize($this->data);

            if(isset($unserialized[0])){
                $this->_unserializedData = $unserialized[0];
            }else{
                $this->_unserializedData = $unserialized;
            }
        }

        return isset($this->_unserializedData[$key])?$this->_unserializedData[$key]:null;
    }
}
