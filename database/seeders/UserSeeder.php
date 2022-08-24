<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Alberto Medina",
            "email" => "amedina@colegiosaucache.cl",
            "password" => Hash::make("alegria2014"),
            "basket" => true,
            "inventary" => true,
            "attendance" => true,
            "loan" => true,
        ]);
    }
}
