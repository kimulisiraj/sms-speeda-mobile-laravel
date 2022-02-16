<?php

namespace NotificationChannels\SmsSpeedaMobile;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

class SmsSpeedaMobile
{

    protected string $apiUrl  = 'http://apidocs.speedamobile.com/api/SendSMS';
    protected string $smsType = 'P';


    public function __construct(
        protected string     $apiKey,
        protected string     $apiPassword,
        protected HttpClient $http,
        public ?bool     $debug = false

    )
    {
    }


    public function getApiKey(): string
    {
        return $this->apiKey;
    }


    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }


    protected function httpClient(): HttpClient
    {
        return $this->http ?? new HttpClient();
    }

    /**
     * @throws CouldNotSendNotification
     */
    public function sendSms(string $to, string $message): Response
    {
        if (empty($this->apiKey)) {
            throw CouldNotSendNotification::apiKeyNotProvided();
        }

        if ($this->debug){
            Log::debug('SmsSpeedaMobile: sendSms', [
                'to' => $to,
                'message' => $message,
            ]);

            return new Response('200', [], 'OK');
        }

        try {
            return $this->httpClient()->post($this->apiUrl, [
                "sms_type"    => "P",
                "encoding"    => "T",
                "sender_id"   => "BULKSMS",
                'textmessage' => $message,
                'phonenumber' => $to,
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }
    }
}
