<?php

namespace App\View\Components;

use App\Models\Serie;
use Illuminate\View\Component;
use Tests\Feature\CasteachingSeriesTest;

class CasteachingSeries extends Component
{
    public static function testedBy(){
        return CasteachingSeriesTest::class;
    }
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $series = Serie::latest()->get();
        return view('components.casteaching-series',[
            'series' => $series
        ]);
    }
}
