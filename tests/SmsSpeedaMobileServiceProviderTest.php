<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;

it('throws an exception if api key or secret is not provided', function (): void {
    Notification::channel('speedaMobile');
})->throws(Exception::class, 'API key is missing.');
