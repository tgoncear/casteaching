<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFormattedCreatedAtAttribute()
    {
        if(!$this->created_at) return '';
        $locale_date = $this->created_at->locale(config('app.locale'));
        return $locale_date->day . ' de ' . $locale_date->monthName . ' de ' . $locale_date->year;
    }

    public function getFormattedForHumansCreatedAtAttribute()
    {
        return optional($this->created_at)->diffForHumans(Carbon::now());
    }

    public function getCreatedAtTimestampAttribute()
    {
        return optional($this->created_at)->timestamp;
    }
}
