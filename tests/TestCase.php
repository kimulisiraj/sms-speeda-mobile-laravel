<?php

namespace NotificationChannels\SmsSpeedaMobile\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use NotificationChannels\SmsSpeedaMobile\SmsSpeedaMobileServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NotificationChannels\\SmsSpeedaMobile\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SmsSpeedaMobileServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_sms-speeda-mobile-laravel_table.php.stub';
        $migration->up();
        */
    }
}
