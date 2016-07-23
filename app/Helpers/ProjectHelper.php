<?php

namespace GoProp\Helpers;

use GoProp\Models\Property;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use GoProp\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectHelper
{
    private $_currentOrder;

    public function getGlobalCartOrder($createIfNone = false)
    {
        if(Cookie::has('goprop_order_id') && !isset($this->_currentOrder)){
            $order = Order::where('id', Cookie::get('goprop_order_id'))
                ->where('status', Order::STATUS_CART)
                ->whereNull('property_id')
                ->first();

            $this->_currentOrder = $order;
        }

        if(empty($this->_currentOrder)){
            if($createIfNone){
                $order = new Order();
                $order->status = Order::STATUS_CART;
                $order->save();

                $this->_currentOrder = $order;

                $cookie = Cookie::make('goprop_order_id', $order->id, 25200);
                Cookie::queue($cookie);
            }
        }

        return $this->_currentOrder;
    }

    public function forgetGlobalCartOrder()
    {
        Cookie::forget('goprop_order_id');
    }

    public function getDefaultAgent()
    {
        //$agent = User::where('username', 'agent1')->firstOrFail();
        return NULL;
    }

    public function getFeaturedProperties($take = 10)
    {
        $qb = Property::active()->where('featured', true)->orderBy(DB::raw('RAND()'))->take($take);
        $properties = $qb->get();

        if($properties->count() < 1){
            $qb = Property::active()->whereHas('photos')->orderBy(DB::raw('RAND()'))->take($take);
            $properties = $qb->get();
        }

        return $properties;
    }

    public function getExclusiveProperties($take = 5)
    {
        $qb = Property::active()
            ->with('type')
            ->orderBy(DB::raw('RAND()'))
            ->take($take);

        $sellQb = clone $qb;
        $sellExclusiveProperties = $sellQb->select(DB::raw('properties.*, "sell" AS exclusive_type'))
            ->whereHas('packages', function($query){
                $query->whereHas('category', function($query2){
                    $query2->where('slug', 'sell');
                });
                $query->where('slug', 'exclusive');
            })->get()->all();

        $rentQb = $qb;
        $rentExclusiveProperties = $qb->select(DB::raw('properties.*, "rent" AS exclusive_type'))
            ->whereHas('packages', function($query){
                $query->whereHas('category', function($query2){
                    $query2->where('slug', 'rent');
                });
                $query->where('slug', 'exclusive');
            })->get()->all();

        $properties = array_merge($rentExclusiveProperties, $sellExclusiveProperties);
        shuffle($properties);
        $properties = array_slice($properties, 0, $take);

        return $properties;
    }

    public function formatNumber($number, $includeCurreny = FALSE, $currency='Rp.')
    {
        return ($includeCurreny?$currency.' ':'').number_format($number, 0, '.', ',');
    }

    public function getPaymentBanks()
    {
        return [
            'BCA' => 'BCA',
            'Mandiri' => 'Mandiri',
            'BNI' => 'BNI',
            'BRI' => 'BRI',
            'CIMB Niaga' => 'CIMB Niaga'
        ];
    }

    public function convertArrayedName($name)
    {
        $name = str_replace('[','.',$name);
        $name = str_replace(']','',$name);

        return $name;
    }

    public function timeAgo($time){
        $datetime1=new DateTime("now");
        $datetime2=new DateTime($time);
        $diff=date_diff($datetime1, $datetime2);
        $timemsg='';
        if($diff->y > 0){
            $timemsg = $diff->y .' '.trans_choice('app.date_label.year', $diff->y);
        }
        else if($diff->m > 0){
            $timemsg = $diff->m . ' '.trans_choice('app.date_label.month', $diff->m);
        }
        else if($diff->d > 0){
            $timemsg = $diff->d .' '.trans_choice('app.date_label.day', $diff->d);
        }
        else if($diff->h > 0){
            $timemsg = $diff->h .' '.trans_choice('app.date_label.hour', $diff->h);
        }
        else if($diff->i > 0){
            $timemsg = $diff->i .' '.trans_choice('app.date_label.minute', $diff->i);
        }
        else if($diff->s > 0){
            $timemsg = $diff->s .' '.trans_choice('app.date_label.second', $diff->s);
        }

        $timemsg = $timemsg.' '.trans('app.date_label.ago');
        return ['timeMessage' => $timemsg, 'difference' => $diff];
    }

    public function getYesNoOptions()
    {
        return [
            1 => trans('forms.yes'),
            0 => trans('forms.no'),
        ];
    }

    public function getSiteName()
    {
        return 'GoProp';
    }

    public function formatTitle($title)
    {
        return $title.' - '.$this->getSiteName();
    }

    public function getSocialShareLink($type, $options)
    {
        $return = '';

        switch($type){
            case 'linkedin':
                $return = url('https://www.linkedin.com/shareArticle?mini=true&url='.$options['url'].'&title='.$options['title'].'&source='.$this->getSiteName());
                break;
            case 'facebook':
                $return = url('https://www.facebook.com/sharer/sharer.php?u='.$options['url']);
                break;
            case 'twitter':
                $return = url('https://twitter.com/intent/tweet?text='.$options['title'].'&url='.$options['url'].'&via='.$this->getSiteName());
                break;
            case 'whatsapp':
                $return = 'whatsapp://send?text='.$options['title'].' - '.$options['url'];
                break;
            case 'googleplus':
                $return = url('https://plus.google.com/share?url='.$options['url']);
                break;
        }

        return $return;
    }

    public function sendMail($to, $subject, $template, $data, $preview=FALSE)
    {
        if(!$preview){
            $result = Mail::send($template, $data, function ($message) use ($data, $subject, $to) {
                $message->from(config('app.system_email_from'), config('app.system_email_from_name'));
                $message->to($to);
                $message->subject($subject);
            });
        }else{
            $result = view($template, $data);
        }

        return $result;
    }
}