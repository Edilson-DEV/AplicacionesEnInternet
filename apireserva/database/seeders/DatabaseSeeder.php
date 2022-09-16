<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Rol::create([
            'name'=> 'Admin',
            'state'=> true
        ]);
        Rol::create([
            'name'=> 'Paciente',
            'state'=> true
        ]);

        Rol::create([
            'name'=> 'Medico',
            'state'=> true
        ]);

        User::factory()->create([
//             'name' => 'Test User',
             'email' => 'admin@gmail.com',
//            'rol_id'=> '1'
         ]);

    }
}
