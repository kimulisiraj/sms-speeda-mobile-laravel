<?php

namespace NotificationChannels\SmsSpeedaMobile\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobile
 */
class SmsSpeedaMobile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sms-speeda-mobile-laravel';
    }
}
