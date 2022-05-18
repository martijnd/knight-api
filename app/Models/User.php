<?php

namespace App\Models;

use App\Exceptions\UserAlreadyFightingException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    ];

    public function initiateFight(Enemy $enemy)
    {
        $this->load('fight');
        if ($this->fight) {
            throw new UserAlreadyFightingException;
        }

        Fight::create(
            [
                'user_id' => $this->id,
                'enemy_id' => $enemy->id,
                'enemy_health' => $enemy->health
            ]
        );
    }

    public function attack()
    {
        $this->load('fight');
        $enemy = $this->fight->enemy;
        $this->health -= $enemy->damage;

        // If killed by enemy attack
        if (! $this->isAlive()) {
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

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function activeWeapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }

    public function fight()
    {
        return $this->hasOne(Fight::class, 'user_id');
    }
}
