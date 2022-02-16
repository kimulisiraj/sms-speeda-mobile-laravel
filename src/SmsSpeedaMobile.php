<?php

namespace NotificationChannels\SmsSpeedaMobile;

use Exception;
use Illuminate\Support\Facades\Http as HttpClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

class SmsSpeedaMobile
{
    protected string $apiUrl = 'http://apidocs.speedamobile.com/api/SendSMS';
    protected string $smsType = 'P';

    public function __construct(
        protected string $apiKey,
        protected string $apiPassword,
        public ?bool     $debug = false
    ) {
    }

    /**
     * @throws CouldNotSendNotification
     */
    public function sendSms(string $to, string $message)
    {
        if (empty($this->apiKey)) {
            throw CouldNotSendNotification::apiKeyNotProvided();
        }

        if ($this->debug) {
            Log::debug('SmsSpeedaMobile: sendSms', ['to' => $to, 'message' => $message,]);

            return HttpClient::response();
        }

        try {
            $response = HttpClient::post($this->apiUrl, [
                "api_id" => $this->apiKey,
                "api_password" => $this->apiPassword,
                "sms_type" => "P",
                "encoding" => "T",
                "sender_id" => "BULKSMS",
                'textmessage' => trim($message),
                'phonenumber' => Str::of($to)->replace(' ', '')->replace('-', ''),
            ]);

            Log::info('SmsSpeedaMobile:', $response->json());

            if ($response->json('status') === 'F') {
                throw CouldNotSendNotification::serviceRespondedWithAnError($response->json('remarks'));
            }

            return $response;
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }
    }
}
