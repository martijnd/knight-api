<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enemy_id',
        'enemy_health',
    ];

    /**
     * The enemy that the user is fighting.
     *
     * @return BelongsTo<Enemy,Fight>
     */
    public function enemy(): BelongsTo
    {
        return $this->belongsTo(Enemy::class);
    }

    public function enemyIsAlive(): bool
    {
        return $this->enemy_health > 0;
    }
}
