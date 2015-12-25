<?php

namespace GoProp\Events;

class PaymentCompletedEvent extends Event
{
    public $transactionDetail;

    public function __construct($transactionDetail)
    {
        $this->transactionDetail = $transactionDetail;
    }
}