<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_date',
        'team_id1',
        'team_id2',
        'winning_team_id',
    ];

    // TODO: Maybe convert later to Eloquent relations
//    public function teams(): BelongsToMany
//    {
//        return $this->belongsToMany(Team::class);
//    }
}
