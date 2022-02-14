<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
/**@covers \App\Http\Controllers\LandingPageController*/
class LandingPageControllerTest extends TestCase
{

    /** @test */
    public function landing_page_have_a_casteaching_series_component(){
        $this->withoutExceptionHandling();
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSee('<div id="casteaching_series">',false);

    }
}
