<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGambleRequest;
use App\Http\Requests\UpdateGambleRequest;
use App\Models\Gamble;
use App\Models\User;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GambleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $games = Game::query()
            ->selectRaw('team1.name AS team_name1, team2.name AS team_name2, games.id, team1_score, team2_score')
            ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
            ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
            ->orderBy('games.game_date')
            ->paginate(9);

        return view('dashboard', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGambleRequest $request
     * @return Response
     */
    public function store(StoreGambleRequest $request)
    {
        if(auth()->user()->credits <= 5) return redirect()->back()->with('failed', 'Je moet minimaal 5 euro op je account hebben!');
        $gambleValidation = $request->safe()->only('chosen_money','chosen_team', 'gameid');
        if($gambleValidation['chosen_money'] > auth()->user()->credits) return redirect()->back()->with('failed', 'Je gekozen bedrag is groter dan wat op account staat!');
        $new_credits = auth()->user()->credits - $gambleValidation['chosen_money'];
        User::query()
        ->update(['credits' => $new_credits]);
        Gamble::create([
            'team_id' => $gambleValidation['chosen_team'],
            'game_id' => $gambleValidation['gameid'],
            'user_id' => auth()->user()->id,
            'bet_credit' => $gambleValidation['chosen_money'],
        ]);

        return redirect()->back()->with('success', 'Gok geplaatst!');

    }

    /**
     * Display the specified resource.
     *
     * @param Gamble $gamble
     * @return Response
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        $games = Game::query()
            ->selectRaw('team1.id as teamid1, team2.id as teamid2, team1.name AS team_name1, team2.name AS team_name2, games.id, team1_score, team2_score')
            ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
            ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
            ->where('games.id', '=', $game->id)
        ->get();
        $gameid = $game->id;

        $gambles = DB::table('gambles')
        ->select(DB::raw('COUNT(gambles.team_id) as aantal, teams.name AS name'))
        ->join('teams', 'gambles.team_id', '=', 'teams.id')
        ->where('gambles.game_id', '=', $gameid)
        ->groupBy("gambles.team_id","name")
        ->get();

        return view('game.index', compact('games','gameid', 'gambles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Gamble $gamble
     * @return Response
     */
    public function edit(Gamble $gamble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGambleRequest  $request
     * @param Gamble $gamble
     * @return Response
     */
    public function update(UpdateGambleRequest $request, Gamble $gamble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Gamble $gamble
     * @return Response
     */
    public function destroy(Gamble $gamble)
    {
        //
    }
}
