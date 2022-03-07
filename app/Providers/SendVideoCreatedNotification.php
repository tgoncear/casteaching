<?php

namespace App\Providers;

use App\Events\VideoCreatedEvent;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendVideoCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VideoCreatedNotification  $event
     * @return void
     */
    public function handle(VideoCreatedEvent $event)
    {
        Notification::route('mail', config('casteaching.admins'))->notify(new VideoCreatedNotification($event->video));
    }
}
