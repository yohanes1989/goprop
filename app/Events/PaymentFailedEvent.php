<?php

namespace GoProp\Events;

class PaymentFailedEvent extends Event
{
    public $transactionDetail;

    public function __construct($transactionDetail)
    {
        $this->transactionDetail = $transactionDetail;
    }
}