<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['published_at'];
    public function getFormattedPublishedAtAttribute(){
        $locale_date = optional($this->published_at->locale('ca_es'));
        return $locale_date->day . ' de ' . $locale_date->monthName . ' de ' . $locale_date->year;
    }
    public function getFormattedForHumansPublishedAtAttribute(){
        return optional($this->published_at)->diffForHumans(Carbon::now());
    }
}
