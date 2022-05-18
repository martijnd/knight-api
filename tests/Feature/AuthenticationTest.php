<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('creates and authenticates a user', function () {
  $username = 'TestUser';
  $payload = [
    'username' => $username,
  ];

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

    // Generate a token
    postJson('/api/tokens/create', $payload)
      ->assertOk();

    postJson('/api/tokens/create', $payload)
      ->assertStatus(401)
      ->assertJson(['message' => 'Username already taken.']);
});
