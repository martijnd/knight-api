<?php

namespace Database\Seeders;

use App\Models\Enemy;
use App\Models\Location;
use App\Models\Weapon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Location::factory(10)->create();

        Weapon::factory()->create([
            'name' => 'Sword',
            'damage' => 14,
        ]);

        Enemy::factory(10)->create();
    }
}
