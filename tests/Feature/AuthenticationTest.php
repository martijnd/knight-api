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
  $response = postJson('/api/tokens/create', $payload);

  $token = $response['token'];

  $response = getJson('/api/user', ['Authorization' => "Bearer $token"]);

  $response->assertOk();

  expect($response->decodeResponseJson()['username'])->toBe($username);
});
