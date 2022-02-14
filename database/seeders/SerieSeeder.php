<?php

namespace Database\Seeders;

use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create_sample_series();
    }
}
