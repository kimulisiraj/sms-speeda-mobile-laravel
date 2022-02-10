<?php

namespace NotificationChannels\SmsSpeedaMobile\Commands;

use Illuminate\Console\Command;

class SmsSpeedaMobileCommand extends Command
{
    public $signature = 'sms-speeda-mobile-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
