<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Game;
use App\Models\Goal;

class Goal extends Pivot
{
    protected $table = 'goals';

    public function games(): belongsToMany
    {
        return $this->belongsToMany(Game::class)->withPivot('goals', 'game_id', 'team_id')->withTimestamps();
    }
}
