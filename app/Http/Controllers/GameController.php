<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Goal;
use App\Models\Team;
use App\Models\Gamble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Game $game)
    {
        $teams = Team::query()
        ->selectRaw('*')
        ->get();

        return view('admin.game.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $gameValidation = $request->safe()->only('dropdown_team1','dropdown_team2', 'game-date');
        $gamedate = date('Y-m-d H:i:s', strtotime($gameValidation['game-date']));

        Game::create([
            'team_id1' => $gameValidation['dropdown_team1'],
            'team_id2' => $gameValidation['dropdown_team2'],
            'game_date' => $gamedate,
        ]);

        return redirect()->back()->with('success', 'Wedstrijd aangemaakt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $games = DB::table('games')
        ->select(DB::raw('team1.name AS name1, team2.name AS name2, games.game_date'))
        ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
        ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
        ->where('games.id', '=', $game->id)
        ->get();
        return view('game.index', compact('games'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
