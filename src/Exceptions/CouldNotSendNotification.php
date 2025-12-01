<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile\Exceptions;

use Exception as ExceptionAlias;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileMessage;

final class CouldNotSendNotification extends ExceptionAlias
{
    public static function serviceRespondedWithAnError(string $message): self
    {
        return new self('Speedamobile Response: '.$message);
    }

    public static function invalidMessageObject($message): self
    {
        $className = is_object($message) ? $message::class : 'Unknown';

        return new self(
            "Notification was not sent. Message object class `{$className}` is invalid. It should
            be either `".SmsSpeedaMobileMessage::class.'`'
        );
    }

    public static function apiKeyNotProvided(): self
    {
        return new self('API key is missing.');
    }

    public static function serviceNotAvailable($message): self
    {
        return new self($message);
    }

    public static function invalidReceiver(): self
    {
        return new self('The notifiable did not have a receiving phone number. Add a routeNotificationForSpeedaMobile method to your notifiable model.
            method or a phone_number attribute to your notifiable.');
    }
}
