<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Weapon;
use App\Models\Enemy;

uses(RefreshDatabase::class);


it('can fight with a monster', function () {
  // Create a knight
  $user = User::factory()->create([
    'health' => 100,
  ]);

  // Create a weapon
  $weapon = Weapon::factory()->create([
    'damage' => 10,
  ]);

  // Give knight the weapon
  $user->active_weapon_id = $weapon->id;
  $user->save();

  // Create an enemy
  $enemy = Enemy::factory()->create([
    'health' => 100,
    'damage' => 4,
  ]);

  $rounds = 0;
  // Fight enemy
  while($enemy->isAlive() && $user->isAlive()) {
    $user->attack($enemy);
    $rounds++;
  }

  // Assert that we won in 10 rounds, with 100 - 4 x 10 = 60 health remaining
  expect($rounds)->toBe(10);
  expect($user->health)->toBe(60);
  expect($enemy)
    ->health->toBe(0)
    ->isAlive()->toBe(false);
});
