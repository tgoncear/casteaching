<?php

namespace Tests\Feature\videos;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function user_can_view_videos()
    {

        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);
        $response = $this->get('/videos/' . $video->id); // SLUGS -> SEO -> TODO
        //Comprovacions -
        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('https://youtu.be/w8j07_DBl_I');
    }
    /**
     * @text
     */
    public function users_cannot_view_not_existing_videos(){
        $response = $this->get("/videos/999");
        $response->assertStatus(404);
    }

}
