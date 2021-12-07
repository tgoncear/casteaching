<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

if(!function_exists('create_default_user')){
    function create_default_user(){

        $userProf = User::create([
            'name' => (config('casteaching.default_user.nameSergi')),
            'email'=> (config('casteaching.default_user.emailSergi')),
            'password'=>Hash::make(config('casteaching.default_user.passwordSergi'))
        ]);
        $userProf->superadmin = true;
        //sd

        $userAlumn = User::create([
            'name' => (config('casteaching.default_user.nameTudor')),
            'email'=> (config('casteaching.default_user.emailTudor')),
            'password'=>Hash::make(config('casteaching.default_user.passwordTudor'))
        ]);

        $userProf->save();

        $userAlumn->save();
        add_personal_team($userAlumn);
        add_personal_team($userProf);
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
if (! function_exists('add_personal_team')) {
    /**
     * @param $user
     */
    function add_personal_team($user): void
    {
        try {
            Team::forceCreate([
                'name' => $user->name . "'s Team",
                'user_id' => $user->id,
                'personal_team' => true
            ]);
        } catch (\Exception $exception) {
//            dd($exception->getMessage());
        }
    }
}
if(!function_exists('create_regular_user')){
    function create_regular_user(){
        $user = User::create([
            'name' => 'PepePringao',
            'email' => 'pringao@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        add_personal_team($user);
        return $user;
    }
}
if(!function_exists('create_superadmin_user')){
    function create_superadmin_user(){
        $user = User::create([
            'name' => 'superAdmin',
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $user->superadmin = true;
        $user->save();
        add_personal_team($user);
        return $user;
    }
}
if(!function_exists('define_gates')){
    function define_gates(){
        Gate::before(function ($user, $ability){
            if($user->isSuperAdmin()){
                return true;
            }
        });
    }
}
if(!function_exists('create_permissions')){
    function create_permissions(){
        Permission::firstOrCreate(['name' => 'videos_manage_index']);
    }
}
if(!function_exists('create_video_manager_user')){
    function create_video_manager_user(){
        $user = User::create([
            'name' => 'videosManager',
            'email' => 'videosManager@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        Permission::firstOrCreate(['name' => 'videos_manage_index']);
        $user->givePermissionTo('videos_manage_index');
        add_personal_team($user);
        return $user;
    }
}
if(!function_exists('create_sample_videos')){
    function create_sample_videos(){
        $video1 = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);
        $video2 = Video::create([
            'title' => 'Ubuntu 102',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);
        return [$video1,$video2];
    }
}
