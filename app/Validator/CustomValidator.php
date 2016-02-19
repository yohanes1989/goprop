<?php namespace GoProp\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class CustomValidator extends Validator
{
    public function validateOldPassword($attribute, $value, $parameters)
    {
        $data = $this->getData();
        $entity = DB::table($parameters[0])->where($parameters[1], $parameters[2])->first();

        return Hash::check($value, $entity->password);
    }

    public function validateDimension($attribute, $value, $parameters)
    {
        $valid = true;
        $values = explode('x', $value);

        if(count($values) == 3){
            foreach($values as $value){
                if(empty($value)){
                    $valid = false;
                    break;
                }
            }
        }else{
            $valid = false;
        }

        return $valid;
    }
}