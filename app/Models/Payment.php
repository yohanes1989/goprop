<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const STATUS_PAID = 'paid';
    const STATUS_UNPAID = 'unpaid';

    const METHOD_NO_PAYMENT = 'no_payment';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_DOKU_CREDIT_CARD = 'myshortcart_credit_card';

    protected $guarded = [];
    protected $dates = ['received_at'];

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function order()
    {
        return $this->belongsTo('GoProp\Models\Order');
    }

    //Statics
    public static function getPaymentMethods($option=null, $all=FALSE)
    {
        $array = [
            self::METHOD_BANK_TRANSFER => [
                'machine_name' => self::METHOD_BANK_TRANSFER,
                'label' => trans('forms.fields.payments.'.self::METHOD_BANK_TRANSFER),
                'description' => trans('forms.fields.payments.'.self::METHOD_BANK_TRANSFER.'_description').'<br/>BCA: 1234567',
            ],
            self::METHOD_DOKU_CREDIT_CARD => [
                'machine_name' => self::METHOD_DOKU_CREDIT_CARD,
                'label' => trans('forms.fields.payments.'.self::METHOD_DOKU_CREDIT_CARD),
                'description' => trans('forms.fields.payments.'.self::METHOD_DOKU_CREDIT_CARD.'_description'),
            ],
        ];

        if($all){
            $array[self::METHOD_NO_PAYMENT] = [
                'machine_name' => self::METHOD_NO_PAYMENT,
                'label' => trans('forms.fields.payments.'.self::METHOD_NO_PAYMENT),
                'description' => '',
            ];
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_PAID => trans('order.payment.status.'.self::STATUS_PAID),
            self::STATUS_UNPAID => trans('order.payment.status.'.self::STATUS_UNPAID),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
