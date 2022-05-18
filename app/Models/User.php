<?php

namespace App\Models;

use App\Exceptions\LocationMismatchException;
use App\Exceptions\UserAlreadyFightingException;
use App\Exceptions\UserIsNotFightingException;
use App\Exceptions\UserIsTravelingException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'weapon_id',
        'location_id',
        'arriving_at',
    ];

    protected $casts = [
        'arriving_at' => 'datetime',
    ];

    public function initiateFight(Enemy $enemy): Fight
    {
        if ($this->isTraveling()) {
            throw new UserIsTravelingException();
        }

        $this->load('fight');
        if ($this->fight) {
            throw new UserAlreadyFightingException;
        }

        if ($this->location_id !== $enemy->location_id) {
            throw new LocationMismatchException;
        }

        return Fight::create(
            [
                'user_id' => $this->id,
                'enemy_id' => $enemy->id,
                'enemy_health' => $enemy->health
            ]
        );
    }

    /**
     * @return Attribute<int,void>
     */
    protected function arrivingIn(): Attribute
    {
        return Attribute::make(
            get: fn () => now()->diffInSeconds($this->arriving_at),
        );
    }

    public function attack(): array
    {
        $this->load('fight');
        if (!$this->fight || !$this->fight->enemy) {
            throw new UserIsNotFightingException();
        }

        $enemy = $this->fight->enemy;
        $this->health -= $enemy->damage;

        // If killed by enemy attack
        if (!$this->isAlive()) {
            $this->update(['health' => 100, 'gold' => intval($this->gold / 2)]);

            return ['message' => 'You died!', 'data' => ['gold' => intval($this->gold / 2)]];
        }

        // Decrease the enemy's health by the amount of damage done by the user
        $this->fight->update([
            'enemy_health' => $this->fight->enemy_health -= $this->activeWeapon?->damage ?? 2
        ]);

        // Decrease the user's health by the amount of damage done by the enemy 
        $this->update(['health' => $this->health - $enemy->damage]);

        // If the enemy is still alive, return the current fight's health amounts
        if ($this->fight->enemyIsAlive()) {
            return [
                'user_health' => $this->health,
                'enemy_health' => $this->fight->enemy_health,
            ];
        }

        // If the enemy is killed, update the user's gold
        $this->update(['gold' => $this->gold += $enemy->loot]);

        // The fight is over, so delete it
        $this->fight->delete();

        return [
            'user_health' => $this->health,
            'enemy_health' => 0,
            'loot' => $enemy->loot,
        ];
    }

    public function travelTo(Location $location): void
    {
        if ($this->location) {
            $this->update([
                'location_id' => $location->id,
                'arriving_at' => now()->addSeconds($this->location->distanceTo($location)),
            ]);
        }
    }

    public function isTraveling(): bool
    {
        return $this->arriving_at > now();
    }

    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    /**
     * @return BelongsTo<Weapon,User>
     */
    public function activeWeapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }

    /**
     * @return HasOne<Fight>
     */
    public function fight(): HasOne
    {
        return $this->hasOne(Fight::class, 'user_id');
    }

    /**
     * @return BelongsTo<Location,User>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
