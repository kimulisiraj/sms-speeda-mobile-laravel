<?php

namespace NotificationChannels\SmsSpeedaMobile\Exceptions;

use Exception as ExceptionAlias;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileMessage;

final class CouldNotSendNotification extends ExceptionAlias
{

    public static function serviceRespondedWithAnError($message): self
    {
        return new CouldNotSendNotification('Speedamobile Response: '.$message);
    }

    public static function invalidMessageObject($message): self
    {
        $className = is_object($message) ? get_class($message) : 'Unknown';

        return new CouldNotSendNotification(
            "Notification was not sent. Message object class `$className` is invalid. It should
            be either `".SmsSpeedaMobileMessage::class.'`');
    }


    public static function apiKeyNotProvided(): self
    {
        return new CouldNotSendNotification('API key is missing.');
    }

    public static function serviceNotAvailable($message): self
    {
        return new CouldNotSendNotification($message);
    }

    public static function invalidReceiver(): self
    {
        return new CouldNotSendNotification( 'The notifiable did not have a receiving phone number. Add a routeNotificationForSmsSpeedaMobile method to your notifiable model.
            method or a phone_number attribute to your notifiable.');
    }
}
