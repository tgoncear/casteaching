<?php

namespace Tests\Feature\videos;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\VideosApiController
 */
class videoApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function users_with_permisions_can_update_videos(){
        $this->loginAsVideoManager();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->deleteJson('/api/videos/' . $video->id);
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json)=>
            $json-> has('id')
                ->where('title',$video['title'])
                ->where('url',$video['url'])
                ->etc()
            );
        $this->assertNull(Video::find($response['id']));
    }
    /**
     * @test
     */
    public function returns_404_when_updating_an_unexisting() {
        $this->loginAsVideoManager();
        $response = $this->putJson("/api/videos/999");
        $response->assertStatus(404);
    }
    /**
     * @test
     */
    public function guest_users_cannot_update_videos(){
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->putJson('/api/videos/' . $video->id);
        objectify($video);
        $response
            ->assertStatus(401);
        $newVideo = Video::find($video['id']);
        $this->assertEquals($newVideo->id,$video->id);
        $this->assertEquals($newVideo->title,$video->title);
        $this->assertEquals($newVideo->description,$video->description);
        $this->assertEquals($newVideo->url,$video->url);


    }
    /**
     * @test
     */
    public function regular_users_cannot_update_videos(){
        $this->loginAsRegularUser();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->putJson('/api/videos/' . $video->id);
        objectify($video);
        $response
            ->assertStatus(403);
        $newVideo = Video::find($video['id']);
        $this->assertEquals($newVideo->id,$video->id);
        $this->assertEquals($newVideo->title,$video->title);
        $this->assertEquals($newVideo->description,$video->description);
        $this->assertEquals($newVideo->url,$video->url);


    }
    /**
     * @test
     */
    public function users_with_permisions_can_destroy_videos(){
        $this->loginAsVideoManager();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->deleteJson('/api/videos/' . $video->id);
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json)=>
            $json-> has('id')
                ->where('title',$video['title'])
                ->where('url',$video['url'])
                ->etc()
            );
        $this->assertNull(Video::find($response['id']));
    }
    /**
     * @test
     */
    public function returns_404_when_deleting_an_unexisting() {
        $this->loginAsVideoManager();
        $response = $this->deleteJson("/api/videos/999");
        $response->assertStatus(404);
    }
    /**
     * @test
     */
    public function guest_users_cannot_destroy_videos(){
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->deleteJson('/api/videos/' . $video->id);
        objectify($video);
        $response
            ->assertStatus(401);
        $this->assertNotNUll(Video::find($video->id));


    }
    /**
     * @test
     */
    public function regular_users_cannot_destroy_videos(){
        $this->loginAsRegularUser();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->deleteJson('/api/videos/' . $video->id);
        objectify($video);
        $response
            ->assertStatus(403);
        $this->assertNotNUll(Video::find($video->id));


    }
    /**
     * @test
     */
    public function regular_users_cannot_store_videos(){
        $this->loginAsRegularUser();
        $response = $this->postJson('/api/videos',$video = [
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        objectify($video);
        $response
            ->assertStatus(403);
        $this->assertCount(0,Video::all());


    }
    /**
     * @test
     */
    public function guest_users_cannot_store_videos(){
        $response = $this->postJson('/api/videos',$video = [
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        objectify($video);
        $response
            ->assertStatus(401);
        $this->assertCount(0,Video::all());


    }
    /**
     * @test
     */
    public function users_with_permission_can_store_videos(){
        $this->loginAsVideoManager();
        $response = $this->postJson('/api/videos',$video = [
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        objectify($video);
        $response
            ->assertStatus(201)
            ->assertJson(fn(AssertableJson $json)=>
            $json->has('id')
                ->where('title',$video['title'])
                ->where('url',$video['url'])
                //->missing("password")
                ->etc());

        $newVideo = Video::find($response['id']);
        $this->assertEquals($response['id'],$newVideo->id);
        $this->assertEquals($response['title'],$newVideo->title);
        $this->assertEquals($response['description'],$newVideo->description);
        $this->assertEquals($response['url'],$newVideo->url);

    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function guest_users_can_show_published_videos()
    {
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);
        $response = $this->getJson('/api/videos/' . $video->id);

        $response->assertStatus(200);
        $response->assertSee($video->title);
        $response->assertSee($video->description);
        $response->assertSee($video->id);
        $response->assertJsonPath('title',$video->title);
        $response->assertJson(fn(AssertableJson $json)=>
            $json->where('id',$video->id)
                ->where('title',$video->title)
                ->where('url',$video->url)
                //->missing("password")
                ->etc()
        );
    }
    /**
     * @test
     */
    public function guest_users_can_index_pulished_videos(){
        $videos = create_sample_videos();
        $response = $this->get('/api/videos/');

        $response->assertStatus(200);
        $response->assertJsonCount(count($videos));
    }

    /**
     * @test void
     */
    public function guest_users_can_show_not_exiting_videos()
    {
        $response = $this->get('/api/videos/999');

        $response->assertStatus(404);
    }

    private function loginAsVideoManager()
    {
        Auth::login(create_video_manager_user());
    }
    private function loginAsRegularUser(){
        Auth::login(create_regular_user());
    }
}
