<?php

use App\Models\Weapon;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('creates and authenticates a user', function () {
  $username = 'TestUser';
  $payload = [
    'username' => $username,
  ];

  Weapon::factory()->create([
    'damage' => 10,
  ]);

  // Generate a token
  $response = postJson('/api/tokens/create', $payload)
    ->assertOk();

  $token = $response['token'];

  $response = getJson('/api/user', ['Authorization' => "Bearer $token"]);

  $response->assertOk();

  expect($response->content())->toContain($username);
});

it('handles existing usernames', function () {
  $username = 'TestUser';
  $payload = [
    'username' => $username,
  ];

  Weapon::factory()->create([
    'damage' => 10,
  ]);

  // Generate a token
  postJson('/api/tokens/create', $payload)
    ->assertOk();

  postJson('/api/tokens/create', $payload)
    ->assertStatus(401)
    ->assertJson(['message' => 'Username already taken.']);
});
