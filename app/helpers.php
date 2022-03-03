<?php

use App\Models\Serie;
use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\File\File;

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
            'serie_id' => 1
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
if (! function_exists('create_user_manager_user')) {
    function create_user_manager_user() {
        $user = User::create([
            'name' => 'UsersManager',
            'email' => 'usersmanager@casteaching.com',
            'password' => Hash::make('12345678')
        ]);

        Permission::create(['name' => 'users_manage_index']);
        Permission::create(['name' => 'users_manage_create']);
        Permission::create(['name' => 'users_manage_store']);
        Permission::create(['name' => 'users_manage_destroy']);
        $user->givePermissionTo('users_manage_index');
        $user->givePermissionTo('users_manage_create');
        $user->givePermissionTo('users_manage_store');
        $user->givePermissionTo('users_manage_destroy');

        add_personal_team($user);
        return $user;
    }
}
if(!function_exists('create_permissions')){
    function create_permissions(){
        Permission::firstOrCreate(['name' => 'videos_manage_index']);
        Permission::firstOrCreate(['name' => 'videos_manage_create']);
        Permission::firstOrCreate(['name' => 'videos_manage_store']);
        Permission::firstOrCreate(['name' => 'videos_manage_edit']);
        Permission::firstOrCreate(['name' => 'videos_manage_update']);
        Permission::firstOrCreate(['name' => 'videos_manage_destroy']);
        Permission::firstOrCreate(['name' => 'users_manage_index']);
        Permission::firstOrCreate(['name' => 'users_manage_create']);
        Permission::firstOrCreate(['name' => 'users_manage_store']);
        Permission::firstOrCreate(['name' => 'users_manage_destroy']);
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
        Permission::firstOrCreate(['name' => 'videos_manage_create']);
        $user->givePermissionTo('videos_manage_create');
        Permission::create(['name' => 'videos_manage_destroy']);
        $user->givePermissionTo('videos_manage_destroy');
        Permission::create(['name' => 'videos_manage_store']);
        $user->givePermissionTo('videos_manage_store');
        Permission::create(['name' => 'videos_manage_edit']);
        Permission::create(['name' => 'videos_manage_update']);
        $user->givePermissionTo('videos_manage_edit');
        $user->givePermissionTo('videos_manage_update');
        add_personal_team($user);
        return $user;
    }
}
if(!function_exists('create_sample_video')) {
    function create_sample_video()
    {
        return Video::create([
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
if(!function_exists('create_sample_videos')){
    function create_sample_videos(){
        $video1 = Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);
        $video2 = Video::create([
            'title' => 'Ubuntu 102',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);
        return [$video1,$video2];
    }
}
if (! function_exists('create_sample_users')) {
    function create_sample_users() {
        $user1 = User::create([
            'name' => 'usuari1',
            'email' => 'usuari1@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $user2 = User::create([
            'name' => 'usuari2',
            'email' => 'usuari2@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $user3 = User::create([
            'name' => 'usuari1',
            'email' => 'usuari3@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        return [$user1, $user2, $user3];
    }
}
class DomainObject implements ArrayAccess, JsonSerializable
{
    private $data = [];

    /**
     * DomainObject constructor.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function __toString()
    {
        return (string) collect($this->data);
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}


if (! function_exists('objectify')) {
    function objectify($array)
    {
        return new DomainObject($array);
    }
}
if (! function_exists('create_sample_series')) {
    function create_sample_series()
    {
        //$path = Storage::disk('public')->putFile('series', new File(base_path('series_photos/tdd.png')));
        $serie1 = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla',
            'image' => "tdd.png",
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com')
        ]);

        sleep(1);
        //$path = Storage::disk('public')->putFile('series', new File(base_path('series_photos/crud_amb_vue_laravel.png')));

        $serie2 = Serie::create([
            'title' => 'Crud amb Vue i Laravel',
            'description' => 'Bla bla bla',
            'image' => 'crud_amb_vue_laravel.png',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com')
        ]);

        sleep(1);
        //$path = Storage::disk('public')->putFile('series', new File(base_path('series_photos/ionic_real_world.png')));

        $serie3 = Serie::create([
            'title' => 'ionic Real world',
            'description' => 'Bla bla bla',
            'image' => 'ionic_real_world.png',
            'teacher_name' => 'Sergi Tur Badenas',
            'teacher_photo_url' => 'https://www.gravatar.com/avatar/' . md5('sergiturbadenas@gmail.com')
        ]);

        sleep(1);
        return [$serie1,$serie2,$serie3];
    }
}
