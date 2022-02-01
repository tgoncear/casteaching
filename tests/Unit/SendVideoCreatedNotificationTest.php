<?php

namespace Tests\Unit;

use App\Console\Commands\TestSendVideoCreatedEmail;
use App\Events\VideoCreatedEvent;
use App\Listeners\SendVideoCreatedNotification;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Notification;
class SendVideoCreatedNotificationTest extends TestCase
{
    public function handle_send_video_created_notification(){
        Notification::fake();
        $sender = new SendVideoCreatedNotification();
        $sender->handle(new VideoCreatedEvent($video = create_sample_video()));
        $admins = config('casteaching.admins');
        Notification::assertSentTo(new AnonymousNotifiable(),VideoCreatedNotification::class,
        function ($notification,$channels,$notifiable) use ($admins, $video){
            return in_array('mail',$channels) && ($notifiable->routes['mail'] === $admins) && Str::contains($notification->toMail($notifiable)->render(),$video->title);
        });
    }
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function example()
    {
        $this->assertTrue(true);
    }
}
