<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Serie;

class VideoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function can_get_fotmatted_published_at_date()
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
        $dateToTest = $video->formatted_published_at;
        $this->assertEquals($dateToTest,'13 de December de 2020');
    }
    public function can_get_fotmatted_published_at_date_when_not_published()
    {
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => null,
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);
        $dateToTest = $video->formatted_published_at;
        $this->assertEquals($dateToTest,'');
    }
    /** @test */
    public function video_have_serie()
    {
        $video = Video::create([
            'title' => 'TDD 101',
            'description' => 'Bla bla bla',
            'url' => 'https://youtu.be/w8j07_DBl_I',
        ]);

        $this->assertNull($video->serie);

        $serie = Serie::create([
            'title' => 'Apren TDD',
            'description' => 'Bla bla bla',
            'image' => 'tdd.png',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com'),
        ]);

        $video->setSerie($serie);

        $this->assertNotNull($video->fresh()->serie);

    }
    /** @test */
    public function video_can_have_owners()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepepardo@casteaching.com',
            'password' => Hash::make('12345678')
        ]);

        $video  = Video::create([
            'title' => 'TDD 101',
            'description' => 'Bla bla bla',
            'url' => 'https://youtu.be/ednlsVl-NHA'
        ]);

        $this->assertNull($video->owner);
        $video->setOwner($user);
        $this->assertNotNull($video->fresh()->user);
        $this->assertEquals($video->user->id,$user->id);
    }

    /**
     * @test
     */
    public function users_can_view_video_series_navigation()
    {
        $serie = Serie::create([
            'title' => 'Introducció a Ubuntu',
            'description' => 'Bla bla bla',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => $gravatar = 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com')
        ]);

        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => $serie->id
        ]);

        $response = $this->get('/videos/' . $video->id); // SLUGS -> SEO -> TODO

        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('13 de desembre de 2020');
        $response->assertSee('https://youtu.be/w8j07_DBl_I');

        // NO ES MOSTRA LA NAVEGACIÓ DE SERIES
        $response->assertSee('<div id="layout_series_navigation"',false);
        $response->assertSee($serie->title);
        $response->assertSee($serie->teacher_name);
        $response->assertSee($gravatar);
    }

}
