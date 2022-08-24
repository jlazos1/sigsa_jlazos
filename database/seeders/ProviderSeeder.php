<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
            "rut" => "15009169-1",
            "name" => "Empresa Macanuda",
            "address" => "Avda. Siempre viva 123",
            "city" => "Arica",
            "email" => "macanudos@macanuda.cl",
        ]);

        Provider::create([
            "rut" => "13864503-7",
            "name" => "Los buena onda",
            "address" => "Avda. terrible carrete 333",
            "city" => "Arica",
            "email" => "contacto@buenaonda.cl",
        ]);
    }
}
