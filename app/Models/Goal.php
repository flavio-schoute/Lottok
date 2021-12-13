<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Goal extends Pivot
{
    public function game(): belongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
