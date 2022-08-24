<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::create([
            "name" => "Sala 3ero Medio A",
            "code" => "A015",
            "place_type_id" => 1
        ]);

        Place::create([
            "name" => "Sala 3ero Medio B",
            "code" => "A016",
            "place_type_id" => 1
        ]);

        Place::create([
            "name" => "Sala 3ero Medio C",
            "code" => "A017",
            "place_type_id" => 1
        ]);
    }
}
