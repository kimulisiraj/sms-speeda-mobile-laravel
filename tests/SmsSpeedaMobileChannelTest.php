<?php

declare(strict_types=1);

use Illuminate\Notifications\Notification;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobile;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileChannel;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileMessage;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

class TestNotification extends Notification
{
    public function toSpeedaMobile($notifiable): SmsSpeedaMobileMessage
    {
        return new SmsSpeedaMobileMessage('Test message body');
    }
}

class TestNotifiable
{
    use Illuminate\Notifications\Notifiable;

    public $phone_number = '94777123456';

    public function routeNotificationForSpeedaMobile()
    {
        return $this->phone_number;
    }
}

class TestInvalidNotifiable
{
    use Illuminate\Notifications\Notifiable;
}

class TestInvalidNotification extends Notification
{
    public function toSpeedaMobile($notifiable): string
    {
        return 'invalid message';
    }
}

it('can send a notification', function (): void {
    $sms = Mockery::mock(SmsSpeedaMobile::class);
    $sms->shouldReceive('sendSms')->once()->with('94777123456', 'Test message body');

    $channel = new SmsSpeedaMobileChannel($sms);
    $channel->send(new TestNotifiable(), new TestNotification());
});

it('throws an exception when notifiable does not have a phone number', function (): void {
    $sms = new SmsSpeedaMobile('key', 'password');
    $channel = new SmsSpeedaMobileChannel($sms);
    $channel->send(new TestInvalidNotifiable(), new TestNotification());
})->throws(CouldNotSendNotification::class, 'The notifiable did not have a receiving phone number. Add a routeNotificationForSpeedaMobile method to your notifiable model.
            method or a phone_number attribute to your notifiable.');
