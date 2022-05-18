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
        'active_weapon_id',
        'fight_id',
    ];

    public function fight(Enemy $enemy)
    {
        if ($this->currentFight) {
            throw new UserAlreadyFightingException;
        }

        $fight = Fight::create(
            [
                'user_id' => $this->id,
                'enemy_id' => $enemy->id,
                'enemy_health' => $enemy->health
            ]
        );

        $this->update(['fight_id' => $fight->id]);
    }

    public function attack(Enemy $enemy)
    {
        $this->health -= $enemy->damage;

        if ($this->isAlive()) {
            $this->currentFight->update([
                'enemy_health' => $this->currentFight->enemy_health -= $this->activeWeapon?->damage ?? 2
            ]);

            if ($this->health - $enemy->damage <= 0) {
                $this->update(['health' => 100, 'gold' => intval($this->gold / 2)]);

                return ['message' => 'You died!', 'data' => ['gold' => intval($this->gold / 2)]];
            }

            $this->update(['health' => $this->health - $enemy->damage]);
        }

        if ($this->currentFight->enemyIsAlive()) {
            return [
                'user_health' => $this->health,
                'enemy_health' => $this->currentFight->enemy_health,
            ];
        }

        $this->update(['gold' => $this->gold += $enemy->loot]);

        $this->currentFight->delete();

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
        return $this->belongsTo(Weapon::class, 'active_weapon_id');
    }

    public function currentFight()
    {
        return $this->belongsTo(Fight::class, 'fight_id');
    }
}
