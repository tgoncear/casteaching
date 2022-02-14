<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SanctumTokenControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function email_is_required_for_issuing_tokens(){
        $response = $this->postJson('/sanctum/token',[
            'password' => '12345678',
            'device_name' => "Pepe's device"
        ]);
        $response->assertStatus(422);
        $this->assertEquals("The given data was invalid.",json_decode($response->getContent())->message);
    }
    /** @test */
    public function invalid_email_gives_incorrect_credentials_error(){

        $user = User::create([
            'name' => 'Pepe Papa',
            'password' => '12345678',
            'email' => 'tgoncear@iesebre.com',

        ]);
        $response = $this->postJson('/sanctum/token',[
            'email' => 'another_email',
            'password' => $user->password,
            'device_name' => $user->name . "'s Device"
        ]);
        $response->assertStatus(422);
        $this->assertEquals("The given data was invalid.",json_decode($response->getContent())->message);
    }
    /** @test */
    public function user_with_valid_credentials_can_issue_a_token()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepe@pardojeans.com',
            'password' => Hash::make('12345678')
        ]);

        $this->assertCount(0,$user->tokens);

        $response = $this->postJson('/api/sanctum/token',[
            'email' => $user->email,
            'password' => '12345678',
            'device_name' => $user->name . "'s device",
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($response->getContent());
        $this->assertCount(1,$user->fresh()->tokens);
    }
}
