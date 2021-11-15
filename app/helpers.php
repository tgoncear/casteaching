<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

if(!function_exists('create_default_user')){
    function create_default_user(){

        $userProf = User::create([
            'name' => (config('casteaching.default_user.nameSergi')),
            'email'=> (config('casteaching.default_user.emailSergi')),
            'password'=>Hash::make(config('casteaching.default_user.passwordSergi'))
        ]);

        $userAlumn = User::create([
            'name' => (config('casteaching.default_user.nameTudor')),
            'email'=> (config('casteaching.default_user.emailTudor')),
            'password'=>Hash::make(config('casteaching.default_user.passwordTudor'))
        ]);
        Team::create([
            'name' => $userProf ->name . "'s Team",
            'user_id' => $userProf -> id,
            'personal_team' => true,
        ]);
        Team::create([
            'name' => $userAlumn ->name . "'s Team",
            'user_id' => $userAlumn -> id,
            'personal_team' => true,
        ]);
    }
}
if(!function_exists('create_default_video')){
    function create_default_video(){
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
