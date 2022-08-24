<?php

namespace Database\Seeders;

use App\Models\PlaceType;
use Illuminate\Database\Seeder;

class PlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlaceType::create([
            "name" => "SALA"
        ]);
        PlaceType::create([
            "name" => "OFICINA"
        ]);
        PlaceType::create([
            "name" => "BODEGA"
        ]);
    }
}
