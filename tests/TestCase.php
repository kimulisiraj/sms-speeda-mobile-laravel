<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName): string => 'NotificationChannels\\SmsSpeedaMobile\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SmsSpeedaMobileServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_sms-speeda-mobile-laravel_table.php.stub';
        $migration->up();
        */
    }
}
