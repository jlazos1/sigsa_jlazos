<?php

namespace Database\Seeders;

use App\Models\TeachingType;
use Illuminate\Database\Seeder;

class TeachingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeachingType::create([
            "code" => "10",
            "name" => "Educación Parvularia",
        ]);

        TeachingType::create([
            "code" => "110",
            "name" => "Enseñanza Básica",
        ]);

        TeachingType::create([
            "code" => "310",
            "name" => "Enseñanza Media Humanístico Científica",
        ]);

        TeachingType::create([
            "code" => "410",
            "name" => "Enseñanza Media T/P Comercial Niños y Jóvenes",
        ]);
    }
}
