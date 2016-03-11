<?php

namespace GoProp\Listeners;

use Carbon\Carbon;
use GoProp\Events\Event;
use GoProp\Models\Order;
use GoProp\Models\Payment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Webpresso\MyShortCart\Facades\MyShortCart;

class PaymentEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $payment = Payment::findOrFail($event->transactionDetail['transaction_id']);

        if($event instanceof \GoProp\Events\PaymentCompletedEvent){
            switch($event->transactionDetail['method']){
                case MyShortCart::getMachineName():
                    if ($event->transactionDetail['status'] == 'success') {
                        if (isset($event->transactionDetail['payment_channel'])) {

                        }else{
                            $payment->order->update(
                                'status' => Order::STATUS_PENDING
                            );

                            $payment->update([
                                'status' => Payment::STATUS_PAID,
                                'amount' => $event->transactionDetail['amount'],
                                'received_at' => Carbon::now()->toDateTimeString()
                            ]);

                            Session::set('payment_redirect_to', route('frontend.property.success', ['id' => $payment->order->property->id]));
                        }
                    }
                    break;
            }
        }elseif($event instanceof \GoProp\Events\PaymentCancelledEvent){
            Session::set('payment_redirect_to', route('frontend.property.review', ['id' => $payment->order->property->id]));
        }elseif($event instanceof \GoProp\Events\PaymentFailedEvent){
            Session::set('payment_redirect_to', route('frontend.property.review', ['id' => $payment->order->property->id]));
        }
    }
}
