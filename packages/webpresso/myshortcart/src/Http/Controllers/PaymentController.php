<?php

namespace Webpresso\MyShortCart\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Webpresso\MyShortCart\Facades\MyShortCart;
use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
    public function __construct(Request $request)
    {
        //Block incoming request from outside MyShortCart IP Address
        $ip_range = config('myshortcart.ip_range');

        $actionName = explode('@', $request->route()->getActionName());
        $actionName = $actionName[1];

        if(in_array($actionName, ['postNotify', 'postVerify'])){
            if (substr($request->ip(), 0, strlen($ip_range)) !== $ip_range){
                abort(403, 'Unauthorized IP.');
            }
        }
    }

    public function postVerify(Request $request)
    {
        $trx = array();

        $transidmerchant = explode( '_', $request->input('TRANSIDMERCHANT') );

        $trx['words']                     = $request->input('WORDS');
        $trx['amount']                    = $request->input('AMOUNT');
        $trx['transaction_id']           = $transidmerchant[1];
        $trx['msc_transaction_id']       = $request->input('TRANSIDMERCHANT');
        $words = sha1(trim($trx['amount']).
            trim(config('myshortcart.shared_key')).
            trim($trx['msc_transaction_id']));

        if ( $trx['words'] == $words )
        {
            $trx['ip_address']            = $request->ip();
            $trx['process_datetime']      = Carbon::now()->toDateTimeString();
            $trx['process_type']          = 'VERIFY';
            $trx['message']               = "Verify process message come from MyShortCart";

            $existingTransactions = MyShortCart::getExistingTransactions($trx['transaction_id'], 'REQUEST', $trx['amount']);

            if ( count($existingTransactions) < 1 )
            {
                return 'Stop : Transaction Not Found';
            }
            else
            {
                MyShortCart::saveTransaction($trx);
                return 'Continue';
            }
        }

        return 'Stop : Request Not Valid';
    }

    public function postNotify(Request $request)
    {
        $trx = array();

        $transidmerchant = explode('_', $request->input('TRANSIDMERCHANT') );

        $trx['amount']                    = $request->input('AMOUNT');
        $trx['transaction_id']           = $transidmerchant[1];
        $trx['msc_transaction_id']       = $request->input('TRANSIDMERCHANT');
        $trx['result_message']          = $request->input('RESULT');
        $trx['ip_address']            = $request->ip();
        $trx['process_datetime']      = Carbon::now()->toDateTimeString();
        $trx['process_type']        = 'NOTIFY';

        $existingTransactions = MyShortCart::getExistingTransactions($trx['transaction_id'], 'VERIFY', $trx['amount']);

        if ( count($existingTransactions) < 1 )
        {
            return 'Stop : Transaction Not Found';
        }
        else
        {
            if ( strtolower($trx['result_message']) == "success" )
            {
                $trx['message'] = "Notify process message come from MyShortCart. Transaction Success : Completed";
            }
            else
            {
                $trx['message'] = "Notify process message come from MyShortCart. Transaction failed : Canceled";
            }

            MyShortCart::saveTransaction($trx);
            return 'Continue';
        }

        return 'Stop : Request Not Valid';
    }

    public function postRedirect(Request $request)
    {
        $trx = array();

        $transidmerchant = explode('_', $request->input('TRANSIDMERCHANT') );

        $trx['amount']                    = $request->input('AMOUNT');
        $trx['transaction_id']           = $transidmerchant[1];
        $trx['msc_transaction_id']       = $request->input('TRANSIDMERCHANT');
        $trx['status_code']          = $request->input('STATUSCODE');

        $existingTransactions = MyShortCart::getExistingTransactions($trx['transaction_id'], 'REQUEST', $trx['amount']);

        if ( count($existingTransactions) < 1 )
        {
            return 'Stop : Transaction Not Found';
        }else{
            if ( $request->has('PAYMENTCODE') ){
                $trx['payment_code'] = $request->input('PAYMENTCODE');
            }

            $trx['result_message']          = $request->input('RESULT');
            $trx['payment_datetime'] = $request->input('TRANSDATE');
            $trx['payment_channel']  = $request->input('PTYPE');
            $trx['extra_info']       = $request->input('EXTRAINFO');
            $trx['ip_address']            = $request->ip();
            $trx['process_datetime']      = Carbon::now()->toDateTimeString();
            $trx['process_type']        = 'REDIRECT';

            if ( $trx['status_code']=="00" || strtolower($trx['result_message']) == 'success' )
            {
                $trx['message'] = "Redirect process message come from MyShortCart. Transaction is Success";
                if(config('myshortcart.completed_event') !== false){
                    $transactionData = [
                        'method' => MyShortCart::getMachineName(),
                        'transaction_id' => $trx['transaction_id'],
                        'amount' => $trx['amount'],
                        'status' => 'success'
                    ];

                    $completedEvent = config('myshortcart.completed_event');
                    Event::fire(new $completedEvent($transactionData));
                }
            }
            else
            {
                if ( ( strtolower($trx['payment_channel']) == "bank transfer" || strtolower($trx['payment_channel']) == "alfamart" ))
                {
                    $trx['message'] = "Redirect process message come from MyShortCart. Transaction is waiting for payment from ATM / ALFA Mart";

                    if(config('myshortcart.completed_event') !== false){
                        $transactionData = [
                            'method' => MyShortCart::getMachineName(),
                            'transaction_id' => $trx['transaction_id'],
                            'amount' => $trx['amount'],
                            'status' => 'success',
                            'payment_channel' => strtolower($trx['payment_channel']),
                        ];

                        $completedEvent = config('myshortcart.completed_event');
                        Event::fire(new $completedEvent($transactionData));
                    }
                }
                else
                {
                    $trx['message'] = "Redirect process message come from MyShortCart. Transaction is Failed";
                    if(config('myshortcart.failed_event') !== false){
                        $transactionData = [
                            'method' => MyShortCart::getMachineName(),
                            'transaction_id' => $trx['transaction_id'],
                            'amount' => $trx['amount'],
                            'status' => 'failed'
                        ];

                        $completedEvent = config('myshortcart.failed_event');
                        Event::fire(new $completedEvent($transactionData));
                    }
                }
            }

            MyShortCart::saveTransaction($trx);

            $redirect_url = Session::pull('payment_redirect_to');
            return redirect($redirect_url);
        }

        return 'Stop : Request Not Valid';
    }

    public function getCancel()
    {

    }
}