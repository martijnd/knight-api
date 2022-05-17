<?php

namespace App\Models;

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
    ];

    public function attack(Enemy $enemy)
    {
        $this->health -= $enemy->damage;
        $enemy->health -= $this->activeWeapon?->damage ?? 2;
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function activeWeapon()
    {
        return $this->belongsTo(Weapon::class, 'active_weapon_id');
    }
}
