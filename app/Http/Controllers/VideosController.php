<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Tests\Feature\videos\VideoTest;

class VideosController extends Controller
{
    public static function testedBy()
    {
        return VideoTest::class;
    }

    public function show($id)
    {
        return view('videos.show',[
            'video' => Video::findOrFail($id)
        ]);
    }
}
