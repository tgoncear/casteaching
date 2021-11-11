<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function create_default_user()
    {
        create_default_user();
        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseHas('users', [
            'email' => config('casteaching.default_user.emailTudor'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => config('casteaching.default_user.nameTudor'),
        ]);

        $user = User::find(1);

        $this->assertNotNull($user);
        $this->assertEquals(config('casteaching.default_user.emailSergi'), $user->email);
        $this->assertEquals(config('casteaching.default_user.nameSergi'), $user->name);

        $this->assertTrue(Hash::check(config('casteaching.default_user.passwordSergi'), $user->password));
    }

    /**
     * @test
     */
    public function create_default_video(){
        create_default_video();
        $this->assertDatabaseCount('videos',1);
    }
}
