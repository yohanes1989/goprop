<?php

return [
    'prefix' => 'GOPROP',
    'shared_key' => 'o5k7p4R3W9u4',
    'store_id' => '00163896',
    'table_name' => 'myshortcart_transactions',
    'completed_event' => 'GoProp\Events\PaymentCompletedEvent',
    'failed_event' => 'GoProp\Events\PaymentFailedEvent',
    'cancelled_event' => 'GoProp\Events\PaymentCancelledEvent',
    'response_function' => ''
];