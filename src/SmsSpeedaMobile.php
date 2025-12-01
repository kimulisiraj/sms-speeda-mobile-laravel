<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http as HttpClient;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

class SmsSpeedaMobile
{
    private string $apiUrl = 'http://apidocs.speedamobile.com/api/SendSMS';

    public function __construct(
        private readonly string $apiKey,
        private readonly string $apiPassword,
        public ?bool $debug = false
    ) {}

    /**
     * @throws CouldNotSendNotification
     */
    public function sendSms(string $to, string $message)
    {
        if ($this->apiKey === '' || $this->apiKey === '0') {
            throw CouldNotSendNotification::apiKeyNotProvided();
        }

        if ($this->debug) {
            Log::debug('SmsSpeedaMobile: sendSms', ['to' => $to, 'message' => $message]);

            return HttpClient::response();
        }

        try {
            $response = HttpClient::post($this->apiUrl, [
                'api_id' => $this->apiKey,
                'api_password' => $this->apiPassword,
                'sms_type' => 'P',
                'encoding' => 'T',
                'sender_id' => 'BULKSMS',
                'textmessage' => preg_replace('/^[\s\p{Z}]+|[\s\p{Z}]+$/u', '', $message),
                'phonenumber' => Str::of($to)->replace(' ', '')->replace('-', ''),
            ]);

            Log::info('SmsSpeedaMobile:', $response->json());

            if ($response->json('status') === 'F') {
                throw CouldNotSendNotification::serviceRespondedWithAnError($response->json('remarks'));
            }

            return $response;
        } catch (Exception $exception) {
            throw_if($exception instanceof CouldNotSendNotification, $exception);

            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }
    }
}
