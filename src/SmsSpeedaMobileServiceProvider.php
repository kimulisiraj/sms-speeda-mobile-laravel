<?php

namespace NotificationChannels\SmsSpeedaMobile;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Http as HttpClient;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\SmsSpeedaMobile\Commands\SmsSpeedaMobileCommand;
use Spatie\LaravelPackageTools\Package;

use Spatie\LaravelPackageTools\PackageServiceProvider;

class SmsSpeedaMobileServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('speedamobile', function ($app) {
                return new SmsSpeedaMobileChannel(new SmsSpeedaMobile(
                    apiKey: config('services.speeda_mobile.api_key'),
                    apiPassword: config('services.speeda_mobile.api_password'),
                    http: new HttpClient(),
                    debug: config('services.speeda_mobile.debug', false)
                ));
            });
        });
    }

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
