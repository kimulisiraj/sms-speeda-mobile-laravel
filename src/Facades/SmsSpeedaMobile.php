<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobile
 */
final class SmsSpeedaMobile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sms-speeda-mobile-laravel';
    }
}
