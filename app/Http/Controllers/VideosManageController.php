<?php

namespace App\Http\Controllers;

use App\Events\VideoCreatedEvent;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tests\Feature\VideosManageControllerTest;

class VideosManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function testedBy()
    {
        return VideosManageControllerTest::class;
    }

    public function index()
    {
        return view('videos.manage.index',[
            'videos' => Video::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
        ]);

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'serie_id' => $request->serie_id,
            'user_id' => $request->user_id
        ]);

        session()->flash('status', 'Successfully created');

        VideoCreatedEvent::dispatch($video);

        // SOLID -> Open a Extension Closed to modification
        //SMELL CODE
//        codi que envia email
//        codi que fa un Activity Log
//        processar per reduir la seva mida
//        asd
//        asd
//        asd
//        asd

        return redirect()->route('manage.videos');

    }

    public function edit($id)
    {
        return view('videos.manage.edit',['video' => Video::findOrFail($id) ]);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->url = $request->url;
        $video->save();

        session()->flash('status', 'Successfully updated');
        return redirect()->route('manage.videos');
    }

    public function destroy($id)
    {
        Video::find($id)->delete();
        session()->flash('status', 'Successfully removed');
        return redirect()->route('manage.videos');
    }
}
