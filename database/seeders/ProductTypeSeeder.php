<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductType::create(["name" => "NOTEBOOK"]);
        ProductType::create(["name" => "TABLET"]);
        ProductType::create(["name" => "SILLAS"]);
        ProductType::create(["name" => "MESAS"]);
    }
}
