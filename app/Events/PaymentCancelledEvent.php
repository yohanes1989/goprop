<?php

namespace GoProp\Events;

class PaymentCancelledEvent extends Event
{
    public $transactionDetail;

    public function __construct($transactionDetail)
    {
        $this->transactionDetail = $transactionDetail;
    }
}