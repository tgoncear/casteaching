<?php

namespace App\Providers;

use App\Notifications\VideoCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    public function handle(VideoCreatedNotification $event)
    {
        //
    }
}
