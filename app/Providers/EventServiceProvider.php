<?php

namespace App\Providers;

use App\Console\Commands\TestSendVideoCreatedEmail;
use App\Events\SeriesImageUpdated;
use App\Events\VideoCreatedEvent;
use App\Listeners\ScheduleSeriesImageProcessing;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VideoCreatedEvent::class=>[
            SendVideoCreatedNotification::class,
        ],
        SeriesImageUpdated::class => [
            ScheduleSeriesImageProcessing::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
