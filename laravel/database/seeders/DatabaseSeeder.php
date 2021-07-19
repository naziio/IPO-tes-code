<?php

namespace Database\Seeders;

use App\Models\Role;
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
         \App\Models\User::factory(1)->create([
             'role' => 2
         ]);

         Role::create([
             'name' => 'user'
         ]);
         Role::create([
              'name' => 'admin'
          ]);
    }
}
