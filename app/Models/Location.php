<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function distanceTo(Location $location): int
    {
        $x = $this->x - $location->x;
        $y = $this->y - $location->y;

        return intval(sqrt($x * $x + $y * $y));
    }
}
