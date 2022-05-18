<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enemy_id',
        'enemy_health',
    ];

    public function enemy()
    {
        return $this->belongsTo(Enemy::class);
    }

    public function enemyIsAlive()
    {
        return $this->enemy_health > 0;
    }
}
