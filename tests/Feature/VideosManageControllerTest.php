<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;
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
