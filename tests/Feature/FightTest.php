<?php

use App\Models\Enemy;
use App\Models\User;
use App\Models\Weapon;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('can fight an enemy', function () {
    // Create a knight
    $user = User::factory()->create([
        'health' => 100,
        'weapon_id' => Weapon::factory()->create([
            'damage' => 10,
        ])
    ]);

    $initialHealth = $user->health;

    Sanctum::actingAs($user);

    // Create an enemy
    $enemy = Enemy::factory()->create([
        'health' => 100,
        'damage' => 4,
    ]);

    postJson(route('fight', $enemy))
        ->assertOk();

    assertDatabaseHas('fights', [
        'user_id' => $user->id,
        'enemy_id' => $enemy->id,
        'enemy_health' => $enemy->health,
    ]);

    $response = postJson(route('attack'))
        ->assertOk();

    expect($response->decodeResponseJson()['data'])
        ->toEqual([
            'user_health' => $initialHealth - $enemy->damage,
            'enemy_health' => $enemy->health - $user->activeWeapon->damage,
        ]);
});

it('can only have one active fight', function () {
    // Create a knight
    $user = User::factory()->create([
        'health' => 100,
        'weapon_id' => Weapon::factory()->create([
            'damage' => 10,
        ])
    ]);

    Sanctum::actingAs($user);

    // Create an enemy
    $enemy = Enemy::factory()->create([
        'health' => 100,
        'damage' => 4,
    ]);

    postJson(route('fight', $enemy))
        ->assertOk();

    postJson(route('fight', $enemy))
        ->assertStatus(301);
});

it('can slay an enemy', function () {
    // Create a knight
    $user = User::factory()->create([
        'health' => 100,
        'weapon_id' => Weapon::factory()->create([
            'damage' => 10,
        ])
    ]);

    $initialHealth = $user->health;
    $initialGold = $user->gold;

    Sanctum::actingAs($user);

    // Create an enemy
    $enemy = Enemy::factory()->create([
        'health' => 100,
        'damage' => 4,
        'loot' => 20,
    ]);

    postJson(route('fight', $enemy))
        ->assertOk();

    assertDatabaseHas('fights', [
        'user_id' => $user->id,
        'enemy_id' => $enemy->id,
        'enemy_health' => $enemy->health,
    ]);

    // Attack 9 times
    for ($i = 0; $i < 9; $i++) {
        postJson(route('attack'))
            ->assertOk();
    }

    // This attack should kill the enemy
    $response = postJson(route('attack'))
        ->assertOk();

    expect($response->decodeResponseJson()['data'])
        ->toEqual([
            'user_health' => $initialHealth - $enemy->damage * 10,
            'enemy_health' => 0,
            'loot' => $enemy->loot,
        ]);

    expect($user)
        ->gold->toEqual($initialGold + $enemy->loot);
});
