<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile;

class SmsSpeedaMobileMessage
{
    public function __construct(
        public string $body
    ) {}
}
