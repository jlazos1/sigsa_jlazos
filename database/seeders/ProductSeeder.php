<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            "name" => "Tablet Willko",
            "description" => "Tablet Android 10” + Protector",
            "product_type_id" => 2,
            "brand" => "Willko",
            "model" => "",
            "sku" => "",
            "code" => "",
            "priceBuy" => 150000,
            "priceSale" => 150000,
        ]);
    }
}
