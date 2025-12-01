<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile;

use Exception;
use Illuminate\Notifications\Notification;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

final readonly class SmsSpeedaMobileChannel
{
    public function __construct(
        private SmsSpeedaMobile $speedaMobile
    ) {}

    /**
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): void
    {
        $to = $this->getTo($notifiable, $notification);

        $message = $notification->toSpeedaMobile($notifiable);

        if (is_string($message)) {
            $message = new SmsSpeedaMobileMessage($message);
        }

        if (! $message instanceof SmsSpeedaMobileMessage) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        try {
            $this->speedaMobile->sendSms(
                to: $to,
                message: $message->body,
            );
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception->getMessage());
        }
    }

    /**
     * Get the address to send a notification to.
     *
     * @throws CouldNotSendNotification
     */
    private function getTo($notifiable, ?Notification $notification = null): mixed
    {
        if ($notifiable->routeNotificationFor('speedaMobile', $notification)) {
            return $notifiable->routeNotificationFor('speedaMobile', $notification);
        }

        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }

        if (isset($notifiable->phone)) {
            return $notifiable->phone;
        }

        throw CouldNotSendNotification::invalidReceiver();
    }
}
