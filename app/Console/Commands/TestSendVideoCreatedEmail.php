<?php

namespace App\Console\Commands;

use App\Notifications\VideoCreatedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestSendVideoCreatedEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:videocreatednotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $video = create_sample_video();
        Notification::route('mail', 'tgoncear@gmail.com')->notify(new VideoCreatedNotification($video));

    }
}
