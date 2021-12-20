<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGambleRequest;
use App\Http\Requests\UpdateGambleRequest;
use App\Models\Gamble;
use App\Models\Game;
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
            ->selectRaw('team1.name AS name1, team2.name AS name2, games.id')
            ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
            ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
            ->paginate(9);

        //'AND', 'team_id1', '=', 'goals.team_id'

        //$goals = Game::with('goals')->get();

        //$games2 = array_merge($games, $goals);
        //$goal1 = [];
        //$goal2 = [];
        //foreach($goals as $kv) {
        //    array_push($goal1, $kv);
        //      $goals = Game::with('goals')->get();
        ////        dd($goals);array_push($goal2, $kv);
        //}
        // dd($goal1);

//

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
        //dd($request->toArray());
        //$userValidation = $request->safe()->only('chosen_team', 'chosen_money');
        $gamble = Gamble::create([
            'team_id' => $request->chosen_team,
            'game_id' => $request->gameid,
            'user_id' => Auth::user()->id,
            'bet_credit' => $request->chosen_money,
        ]);

        return redirect()->route('gamble.index')->with('success', 'Gok geplaatst!');





























































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

        $games = DB::table('games')
        ->select(DB::raw('team1.id as teamid1, team2.id as teamid2, team1.name AS name1, team2.name AS name2, games.game_date'))
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
