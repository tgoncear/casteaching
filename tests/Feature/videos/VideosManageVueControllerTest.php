<?php

namespace Tests\Feature\videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class VideosManageVueControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /** @test */

    public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();

        $response = $this->get('/vue/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.vue.index');
    }
}
