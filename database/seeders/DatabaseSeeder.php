<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => (config('casteaching.default_user.nameSergi')),
            'email'=> (config('casteaching.default_user.emailSergi')),
            'password'=>Hash::make(config('casteaching.default_user.passwordSergi'))
        ]);
        User::create([
            'name' => (config('casteaching.default_user.nameTudor')),
            'email'=> (config('casteaching.default_user.emailTudor')),
            'password'=>Hash::make(config('casteaching.default_user.passwordTudor'))
        ]);
        Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);

    }
}
