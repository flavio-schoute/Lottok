<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGambleRequest;
use App\Models\Gamble;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GambleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $games = DB::table('games')
//        ->select(DB::raw('team1.name AS name1, team2.name AS name2, games.id'))
//        ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
//        ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
//        ->get();
        //'AND', 'team_id1', '=', 'goals.team_id'

        //$goals = Game::with('goals')->get();

        //$games2 = array_merge($games, $goals);
        //$goal1 = [];
        //$goal2 = [];
        //foreach($goals as $kv) {
        //    array_push($goal1, $kv);
        //    array_push($goal2, $kv);
        //}
        // dd($goal1);

        $games = Game::with('teams')->get();

        dd($games);

        return view('dashboard', compact('games'));




















































    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGambleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGambleRequest $request)
    {
        //dd($request->toArray());
        //$userValidation = $request->safe()->only('chosen_team', 'chosen_money');
        $gamble = Gamble::create([
            'team_id' => $request->chosen_team,
            'game_id' => $request->gameid,
            'user_id' => 1,
            'bet_credit' => $request->chosen_money,
        ]);

        return redirect()->route('gamble.index')->with('success', 'Gok geplaatst!');





























































    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gamble  $gamble
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);

        $games = DB::table('games')
        ->select(DB::raw('team1.id as teamid1, team2.id as teamid2, team1.name AS name1, team2.name AS name2, games.game_date'))
        ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
        ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
        ->where('games.id', '=', $game->id)
        ->get();
        $gameid = $game->id;
        return view('game.index', compact('games','gameid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gamble  $gamble
     * @return \Illuminate\Http\Response
     */
    public function edit(Gamble $gamble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGambleRequest  $request
     * @param  \App\Models\Gamble  $gamble
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGambleRequest $request, Gamble $gamble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gamble  $gamble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gamble $gamble)
    {
        //
    }
}
