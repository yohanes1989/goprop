<?php

namespace Webpresso\MyShortCart;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class MyShortCart
{
    private $_machine_name = 'myshortcart_credit_card';

    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getMachineName()
    {
        return $this->_machine_name;
    }

    /*
     * Save transaction into database
     *
     * @param string $transaction_id Transaction ID
     * @parem float $amount Transaction amount
     * @return bool
     */
    public function saveRequestTransaction($orderData)
    {
        $process_type = 'REQUEST';
        $process_datetime = Carbon::now()->toDateTimeString();

        $transaction = [
            'ip_address' => $orderData['ip_address'],
            'process_type' => $process_type,
            'process_datetime' => $process_datetime,
            'transaction_id' => $orderData['transaction_id'],
            'msc_transaction_id' => $orderData['msc_transaction_id'],
            'amount' => $this->formatNumber($orderData['amount']),
            'words' => $orderData['words'],
            'message' => 'Transaction request start',
        ];

        $this->db->table(config('myshortcart.table_name'))->insert($transaction);
    }

    public function saveTransaction($transaction)
    {
        $this->db->table(config('myshortcart.table_name'))->insert($transaction);
    }

    public function getExistingTransactions($transaction_id, $process_type = NULL, $amount = NULL)
    {
        $qb = $this->db->table(config('myshortcart.table_name'))->where('transaction_id', $transaction_id);

        if(!empty($process_type)){
            $qb->where('process_type', $process_type);
        }

        if(!empty($amount)){
            $qb->where('amount', $amount);
        }

        $transactions = $qb->get();

        return $transactions;
    }

    public function formatNumber($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function formatBasket($data)
    {
        $basket = '';
        foreach($data as $idx=>$datum){
            if($idx != 0){
                $basket .= ';';
            }
            $basket .= $datum['name'].','.$this->formatNumber($datum['price']).','.$datum['quantity'].','.$this->formatNumber($datum['price'] * $datum['quantity']);
        }

        return $basket;
    }

    public function renderForm($orderInfo)
    {
        $postUrl = 'https://apps.myshortcart.com/payment/request-payment/';

        $transaction_data['submit_url'] = $postUrl;
        $transaction_data['url'] = $orderInfo['url'];
        $transaction_data['store_id'] = config('myshortcart.store_id');
        $transaction_data['basket'] = $orderInfo['basket'];
        $transaction_data['transaction_id'] = $orderInfo['transaction_id'];
        $transaction_data['msc_transaction_id'] = $orderInfo['msc_transaction_id'];
        $transaction_data['amount'] = $orderInfo['amount'];
        $transaction_data['words'] = $orderInfo['words'];
        $transaction_data['customer_name'] = $orderInfo['customer_name'];
        $transaction_data['customer_email'] = $orderInfo['customer_email'];
        $transaction_data['customer_phone'] = $orderInfo['customer_phone'];
        $transaction_data['customer_work_phone'] = $orderInfo['customer_work_phone'];
        $transaction_data['customer_mobile_phone'] = $orderInfo['customer_mobile_phone'];
        $transaction_data['customer_address'] = $orderInfo['customer_address'];
        $transaction_data['customer_postal_code'] = $orderInfo['customer_postal_code'];
        $transaction_data['customer_city'] = $orderInfo['customer_city'];
        $transaction_data['customer_state'] = $orderInfo['customer_state'];
        $transaction_data['customer_country'] = $orderInfo['customer_country'];
        $transaction_data['customer_birthday'] = $orderInfo['customer_birthday'];
        $transaction_data['shipping_address'] = $orderInfo['shipping_address'];
        $transaction_data['shipping_postal_code'] = $orderInfo['shipping_postal_code'];
        $transaction_data['shipping_city'] = $orderInfo['shipping_city'];
        $transaction_data['shipping_state'] = $orderInfo['shipping_state'];
        $transaction_data['shipping_country'] = $orderInfo['shipping_country'];

        return view('myshortcart::payment_form', $transaction_data);
    }
}