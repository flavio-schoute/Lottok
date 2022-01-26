<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGambleRequest;
use App\Http\Requests\UpdateGambleRequest;
use App\Models\Gamble;
use App\Models\User;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GambleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
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
     * @return RedirectResponse
     */
    public function store(StoreGambleRequest $request): RedirectResponse
    {
        // Get the validated data
        $gambleValidation = $request->safe()->only('chosen_money','chosen_team', 'game_id');

        // TODO: Bug fix, the money can get typed with , but it rounds up
        $amount = floatval($gambleValidation['chosen_money']);

        // Check if user put in more than 1 euro
        if ($amount < 1) {
            return redirect()->back()->withErrors('Je moet minimaal 1 euro inzetten om te kunnen gokken!');
        }

        // Get the game data
        $apiUrl = config('api.base_url');
        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/games/' . $gambleValidation['game_id']);

        $game = json_decode($apiResponse);

        // Get 15 minutes before the match and check that
        $timeBeforeMatch = Carbon::parse($game->data->game_date)->subMinutes(15);
<<<<<<< Updated upstream
        // If the time before match has been pasted you can't place bet and get error
        if ($timeBeforeMatch->isPast()) {
            return redirect()->back()->withErrors('Je kan een kwartier voor de wedstrijd niet meer gokken!');
        }
        // Checks if user has atleast 5 euro on account
=======
        if ($timeBeforeMatch->isPast()) {
            return redirect()->back()->withErrors('Je kan een kwartier voor de wedstrijd niet meer gokken!');
        }

        // Check user credits
>>>>>>> Stashed changes
        if(auth()->user()->credits < 5) {
            return redirect()->back()->withErrors('Je moet minimaal 5 euro op je account hebben!');
        }
        // Checks if enough money is on account
        if($amount > auth()->user()->credits) {
            return redirect()->back()->withErrors('Je gekozen bedrag is groter dan wat op account staat!');
        }
<<<<<<< Updated upstream
        // Calculates new amount credits from user
        $userNewCredits = auth()->user()->credits - $amount;
        // Updates the money from the user
        User::query()->where('id', '=', auth()->user()->id)->update(['credits' => $userNewCredits]);
        // Stores data in database
=======

        // Subtract the credits and update the user credits
        $userNewCredits = auth()->user()->credits - $amount;
        User::query()->where('id', '=', auth()->user()->id)->update(['credits' => $userNewCredits]);

        // Put the gamble in the database
>>>>>>> Stashed changes
        Gamble::create([
            'team_id' => $gambleValidation['chosen_team'],
            'game_id' => $gambleValidation['game_id'],
            'user_id' => auth()->user()->id,
            'bet_credit' => $amount,
        ]);

        return redirect()->back()->with('success', 'Gok geplaatst!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
<<<<<<< Updated upstream
    public function show(int $id)
    {   
        // Get the game data
=======
    public function show(int $id): View|Factory|RedirectResponse|Application
    {
>>>>>>> Stashed changes
        $apiUrl = config('api.base_url');

        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/games/' . $id);

        $games = json_decode($apiResponse);

        $timeBeforeMatch = Carbon::parse($games->data->game_date)->subMinutes(15);
        
        //Checkes if time has pasted
        if ($timeBeforeMatch->isPast()) {
            return redirect()->route('games.index')->withErrors('Je kan een kwartier voor de wedstrijd niet meer gokken!');
        }

        // Finds the current gamble if made.
        $foundedGamble = Gamble::select(['id', 'bet_credit'])->where('user_id', auth()->user()->id)->where('game_id', $games->data->id)->get();

        return view('gamble.index', compact(['games', 'foundedGamble' , 'timeBeforeMatch']));
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
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $gamble = Gamble::findOrFail($id);

        // Get the current game
        $apiUrl = config('api.base_url');
        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/games/' . $gamble->game_id);

        $games = json_decode($apiResponse);

        // Check if the user wants to delete their guess before the match start
        $timeBeforeMatch = Carbon::parse($games->data->game_date)->subMinutes(15);
        if ($timeBeforeMatch->isPast()) {
            return redirect()->route('games.index')->withErrors('Je kan een kwartier voor de wedstrijd je gok niet meer annuleren.');
        }

        $credits = $gamble->bet_credit;

        // Delete the gamble
        $gamble->delete();

        // Give the credits back to the user
        $currentCredits = auth()->user()->credits;
        $userNewCredits = $currentCredits + $credits;

        User::query()->where('id', '=', auth()->user()->id)->update(['credits' => $userNewCredits]);

        // Redirects the user back with a succes message
        return redirect()->back()->with('success','De gok is verwijderd');
    }
}
