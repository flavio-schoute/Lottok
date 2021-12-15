<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Goal;
use App\Models\Gamble;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $games = DB::table('games')
        ->select(DB::raw('team1.name AS name1, team2.name AS name2, games.id'))
        ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
        ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
        ->get();
        //'AND', 'team_id1', '=', 'goals.team_id'

        $goals = Game::with('goals')->get();

        //$games2 = array_merge($games, $goals);
       //$goal1 = [];
       //$goal2 = [];
       //foreach($goals as $kv) {
       //    array_push($goal1, $kv);
       //    array_push($goal2, $kv);
       //}
        //dd($goal1);


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
