<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(["name" => "Root"]);
        Role::create(["name" => "Administrador(a)"]);
        Role::create(["name" => "Profesor(a)"]);
        Role::create(["name" => "Director(a)"]);
        Role::create(["name" => "Enlaces"]);
        Role::create(["name" => "Auxiliar"]);
        Role::create(["name" => "Jefe(a) de UTP"]);
        Role::create(["name" => "Inspector"]);
        Role::create(["name" => "Administrativo"]);
        Role::create(["name" => "Funcionario"]);
    }
}
