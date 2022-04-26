<?php

namespace App\Http\Controllers;

use App\Events\SeriesImageUpdated;
use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\Series\SeriesImagesManageControllerTest;

class SeriesImagesManageController extends Controller
{
    public static function testedBy()
    {
        return SeriesImagesManageControllerTest::class;
    }

    public function update(Request $request)
    {
        $serie = Serie::findOrFail($request->id);
        $serie->image = $request->file('image')->store('series','public');
        $serie->save();
        session()->flash('status', __('Successfully updated'));
        SeriesImageUpdated::dispatch($serie);
        return back()->withInput();
    }
}
