<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Enemy
 *
 * @property int $id
 * @property string $name
 * @property int $health
 * @property int $damage
 * @property int $loot
 * @property int $location_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\EnemyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereHealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereLoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enemy whereUpdatedAt($value)
 */
	class Enemy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fight
 *
 * @property int $id
 * @property int $user_id
 * @property int $enemy_id
 * @property int $enemy_health
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Enemy $enemy
 * @method static \Database\Factories\FightFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereEnemyHealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereEnemyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fight whereUserId($value)
 */
	class Fight extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property int $x
 * @property int $y
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\LocationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereY($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property int $health
 * @property int $gold
 * @property int|null $weapon_id
 * @property int $location_id
 * @property \Illuminate\Support\Carbon|null $arriving_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Weapon|null $activeWeapon
 * @property-read \App\Models\Fight|null $fight
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereArrivingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWeaponId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Weapon
 *
 * @property int $id
 * @property string $name
 * @property int $damage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\WeaponFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weapon whereUpdatedAt($value)
 */
	class Weapon extends \Eloquent {}
}

