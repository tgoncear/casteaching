<?php

namespace Tests\Feature;

use App\Events\VideoCreatedEvent;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use App\Models\Serie;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /** @test  */
    public function user_with_permissions_can_store_videos_with_serie()
    {
        $this->loginAsVideoManager();

        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com'),
        ]);

        $video = objectify($videoArray = [
            'title' => 'HTTP for noobs',
            'description' => 'Te ensenyo tot el que se sobre HTTP',
            'url' => 'https://tubeme.acacha.org/http',
            'serie_id' => $serie->id
        ]);
        Event::fake();
        $response = $this->post('/manage/videos',$videoArray);

        Event::assertDispatched(VideoCreatedEvent::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status', 'Successfully created');

        $videoDB = Video::first();
        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title,$video->title);
        $this->assertEquals($videoDB->description,$video->description);
        $this->assertEquals($videoDB->url,$video->url);
        $this->assertEquals($videoDB->series_id,$serie->id);
        $this->assertNull($video->published_at);

    }

    /** @test **/
    public function title_is_required()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function description_is_required()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function url_is_required()
    {
        $this->markTestIncomplete();
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');

        $response->assertSee('<form data-qa="form_video_create"',false);
    }

    /** @test  */
    public function user_without_videos_manage_create_cannot_see_add_videos()
    {
        Permission::firstOrCreate(['name' => 'videos_manage_index']);
        $user = User::create([
            'name' => 'Pepe',
            'email' => 'Pepe',
            'password' => Hash::make('12345678')
        ]);
        $user->givePermissionTo('videos_manage_index');
        add_personal_team($user);

        Auth::login($user);

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');

        $response->assertDontSee('<form data-qa="form_video_create"',false);
    }
    public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();
        $videos = create_sample_videos();
        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertViewHas('videos',function ($v) use ($videos){
            return count($videos) === $v->count() && get_class($v) === Collection::class &&
                get_class($videos[0]) === Video::class;
        });
        foreach ($videos as $video) {
            $response->assertSee($video->id);
            $response->assertSee($video->title);

        }
    }
    /** @test */
    public function regular_users_cannot_manage_videos(){
        $this->loginAsRegularUser();
        $response = $this->get('/manage/videos');
        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function guest_users_cannot_manage_videos(){
        $response = $this->get('/manage/videos');

        $response->assertRedirect(route('login'));
    }
    /** @test */
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
    }

//    /** @test */
//    public function user_with_permissions_can_store_videos()
//    {
//
//        $this->loginAsVideoManager();
//
//        $video = objectify($videoArray = [
//            'title' => 'HTTP for noobs',
//            'description' => 'Te ensenyo tot el que se sobre HTTP',
//            'url' => 'https://tubeme.acacha.org/http',
//        ]);
//
//        Event::fake();
//        $response = $this->post('/manage/videos',$videoArray);
//
//        Event::assertDispatched(VideoCreatedEvent::class);
//
//        $response->assertRedirect(route('manage.videos'));
//        $response->assertSessionHas('status', 'Successfully created');
//
//        $videoDB = Video::first();
//
//        $this->assertNotNull($videoDB);
//        $this->assertEquals($videoDB->title,$video->title);
//        $this->assertEquals($videoDB->description,$video->description);
//        $this->assertEquals($videoDB->url,$video->url);
//        $this->assertNull($video->published_at);
//
//
//
//    }
    /** @test  */
    public function user_with_permissions_can_destroy_videos() {
        $this->loginAsVideoManager();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);

        $response = $this->delete('/manage/videos/' . $video->id);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status', 'Successfully removed');

        $this->assertNull(Video::find($video->id));
        $this->assertNull($video->fresh());

    }

    /** @test  */
    public function user_without_permissions_cannot_destroy_videos() {
        $this->loginAsRegularUser();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);

        $response = $this->delete('/manage/videos/' . $video->id);

        $response->assertStatus(403);
    }
    //hola
    /** @test  */
    public function user_with_permissions_can_update_videos()
    {
        $this->loginAsVideoManager();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);

        // URI ENDPOINT -> API -> FUNCTION
        $response = $this->put('/manage/videos/' . $video->id,[
                'title' => 'HTTP',
                'description' => "HTTP",
                'url' => 'https://tubeme.acacha.org/http_cracks',
            ]
        );

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status', 'Successfully updated');


        $newVideo = Video::find($video->id);
        $this->assertEquals('HTTP', $newVideo->title);
        $this->assertEquals("HTTP", $newVideo->description);
        $this->assertEquals('https://tubeme.acacha.org/http_cracks', $newVideo->url);
        $this->assertEquals($video->id, $newVideo->id);

    }

    /** @test  */
    public function user_with_permissions_can_see_edit_videos()
    {
        $this->withoutDeprecationHandling();
        $this->loginAsVideoManager();
        $video = Video::create([
            'title' => 'HTTP',
            'description' => 'HTTP',
            'url' => 'https://tubeme.acacha.org/http',
        ]);

        $response = $this->get('/manage/videos/' . $video->id);

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.edit');
        $response->assertViewHas('video', function($v) use ($video) {
            return $video->is($v);
        });

        $response->assertSee('<form data-qa="form_video_edit"',false);

        $response->assertSeeText($video->title);
        $response->assertSeeText($video->description);
        $response->assertSee($video->url);

    }

    private function loginAsVideoManager()
    {
        Auth::login(create_video_manager_user());
    }

    private function loginAsSuperAdmin()
    {
        Auth::login(create_superadmin_user());
    }

    private function loginAsRegularUser()
    {
        Auth::login(create_regular_user());
    }

}
