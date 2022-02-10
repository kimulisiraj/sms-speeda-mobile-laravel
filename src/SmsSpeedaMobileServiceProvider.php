<?php

namespace NotificationChannels\SmsSpeedaMobile;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NotificationChannels\SmsSpeedaMobile\Commands\SmsSpeedaMobileCommand;

class SmsSpeedaMobileServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('sms-speeda-mobile-laravel')
            ->hasConfigFile('sms-speeda-mobile')
            /*
            ->hasViews()
            ->hasMigration('create_sms_speeda_mobile_table')
            */
            ->hasCommand(SmsSpeedaMobileCommand::class);
    }
}
