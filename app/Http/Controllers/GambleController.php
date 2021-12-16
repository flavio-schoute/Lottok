<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Request;
use App\Models\Gamble;
use App\Http\Requests\StoreGambleRequest;
use App\Http\Requests\UpdateGambleRequest;

class GambleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return view('game.index');
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
        dd('sss');
         //$userValidation = $request->safe()->only('chosen_team', 'chosen_money');
        $gamble = Gamble::create([
            'team_id' => 1,
            'game_id' => 1,
            'user_id' => 1,
            'bet_credit' => 2,
        ]);
        dd($gamble);
        return redirect()->route('game.index')->with('success', 'Gok geplaatst!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gamble  $gamble
     * @return \Illuminate\Http\Response
     */
    public function show(Gamble $gamble)
    {
        //
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
