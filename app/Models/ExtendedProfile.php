<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedProfile extends Model
{
    const PROPERTY_SELL_1 = 1;
    const PROPERTY_SELL_2 = 2;
    const PROPERTY_SELL_3 = 3;
    const PROPERTY_SELL_4 = 4;
    const PROPERTY_SELL_5 = 5;

    const PROPERTY_LET_1 = 1;
    const PROPERTY_LET_2 = 2;
    const PROPERTY_LET_3 = 3;
    const PROPERTY_LET_4 = 4;
    const PROPERTY_LET_5 = 5;

    public $timestamps = FALSE;

    protected $guarded = [];

    //Statics
    public static function getPropertySellLabel($option=null)
    {
        $array = [
            self::PROPERTY_SELL_1 => trans('extended_profile.property_sell.'.self::PROPERTY_SELL_1),
            self::PROPERTY_SELL_2 => trans('extended_profile.property_sell.'.self::PROPERTY_SELL_2),
            self::PROPERTY_SELL_3 => trans('extended_profile.property_sell.'.self::PROPERTY_SELL_3),
            self::PROPERTY_SELL_4 => trans('extended_profile.property_sell.'.self::PROPERTY_SELL_4),
            self::PROPERTY_SELL_5 => trans('extended_profile.property_sell.'.self::PROPERTY_SELL_5),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getPropertyLetLabel($option=null)
    {
        $array = [
            self::PROPERTY_LET_1 => trans('extended_profile.property_let.'.self::PROPERTY_LET_1),
            self::PROPERTY_LET_2 => trans('extended_profile.property_let.'.self::PROPERTY_LET_2),
            self::PROPERTY_LET_3 => trans('extended_profile.property_let.'.self::PROPERTY_LET_3),
            self::PROPERTY_LET_4 => trans('extended_profile.property_let.'.self::PROPERTY_LET_4),
            self::PROPERTY_LET_5 => trans('extended_profile.property_let.'.self::PROPERTY_LET_5),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getReferralSourceLabel($option=null)
    {
        $array = [
            'signboard' => trans('extended_profile.referral_source.signboard'),
            'recommendation' => trans('extended_profile.referral_source.recommendation'),
            'search_engine' => trans('extended_profile.referral_source.search_engine'),
            'facebook' => trans('extended_profile.referral_source.facebook'),
            'twitter' => trans('extended_profile.referral_source.twitter'),
            'tv' => trans('extended_profile.referral_source.tv'),
            'brochure' => trans('extended_profile.referral_source.brochure'),
            'news' => trans('extended_profile.referral_source.news'),
            'other' => trans('extended_profile.referral_source.other'),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
