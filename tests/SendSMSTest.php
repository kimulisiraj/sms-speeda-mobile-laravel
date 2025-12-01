<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobile;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

it('can send sms', function (): void {
    Http::fake([
        'apidocs.speedamobile.com/api/SendSMS' => Http::response(['status' => 'S', 'remarks' => 'SUCCESS']),
    ]);

    $sms = new SmsSpeedaMobile('test_api_key', 'test_api_password');
    $response = $sms->sendSms('94777123456', 'Test message');

    expect($response->json('status'))->toBe('S');
});

it('throws an exception if api key is not provided', function (): void {
    $sms = new SmsSpeedaMobile('', '');
    $sms->sendSms('94777123456', 'Test message');
})->throws(CouldNotSendNotification::class, 'API key is missing.');

it('throws an exception if service responds with an error', function (): void {
    Http::fake([
        'apidocs.speedamobile.com/api/SendSMS' => Http::response(['status' => 'F', 'remarks' => 'FAILURE']),
    ]);

    $sms = new SmsSpeedaMobile('test_api_key', 'test_api_password');
    $sms->sendSms('94777123456', 'Test message');
})->throws(CouldNotSendNotification::class, 'Speedamobile Response: FAILURE');

it('can send sms in debug mode', function (): void {
    Http::fake();

    $sms = new SmsSpeedaMobile('test_api_key', 'test_api_password', true);
    $sms->sendSms('94777123456', 'Test message');

    Http::assertNothingSent();
});
