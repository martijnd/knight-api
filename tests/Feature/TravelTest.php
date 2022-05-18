<?php

use App\Models\Enemy;
use App\Models\Location;
use App\Models\User;
use App\Models\Weapon;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

it('user cannot fight while travelling', function () {
  // Create user in location A
  $locationA = Location::factory()->create([
    'x' => 0,
    'y' => 0,
  ]);
  // Create a knight
  $user = User::factory()->create([
    'health' => 100,
    'weapon_id' => Weapon::factory()->create([
      'damage' => 10,
    ]),
    'location_id' => $locationA->id,
  ]);

  Sanctum::actingAs($user);

  $locationB = Location::factory()->create([
    'x' => 0,
    'y' => 10,
  ]);
  // Create enemy in location B
  $enemy = Enemy::factory()->create([
    'health' => 100,
    'damage' => 4,
    'location_id' => $locationB->id,
  ]);

  // Assert that user cannot fight enemy
  postJson(route('fight', $enemy))
    ->assertStatus(401)
    ->assertJson(['message' => 'You are not in the correct location.']);

  // Travel to location B
  $user->travelTo($locationB);

  // Assert that user cannot fight enemy while traveling
  postJson(route('fight', $enemy))
    ->assertStatus(401)
    ->assertJson([
      'message' => 'User is currently traveling',
    ]);

  $this->travel(4)->seconds();

  expect($user->arriving_in)->toBe(5);
  $this->travel(2)->seconds();
  expect($user->arriving_in)->toBe(3);

  // Move in time until after user has arrived
  $this->travel(7)->seconds();

  // Assert that user can fight enemy
  postJson(route('fight', $enemy))
    ->assertOk();

  expect($user)
    ->location_id->toBe($locationB->id);
});
