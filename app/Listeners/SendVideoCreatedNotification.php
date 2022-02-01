<?php

namespace App\Listeners;

use App\Events\VideoCreatedEvent;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Tests\Unit\SendVideoCreatedNotificationTest;

class SendVideoCreatedNotification implements ShouldQueue
{
    public $video;
    public function __construct($video){
        $this->video = $video;
    }
    public static function testedBy(){
        return SendVideoCreatedNotificationTest::class;
    }
    /**
     * Handle the event.
     *
     * @param  VideoCreatedEvent  $event
     * @return void
     */
    //s
    public function handle(VideoCreatedEvent $event)
    {
        $video = create_sample_video();
        Notification::route('mail','tgoncear@iesebre.com')->notify(new VideoCreatedNotification($video));
    }
}
