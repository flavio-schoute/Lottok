<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        // Check if the user a gamble streak of 10, if so then give them a bonus and reset the streak
        if (auth()->user()->current_guess_streak == 10) {
            $currentUserCredits = auth()->user()->credits;
            $newUserCredits = $currentUserCredits + 10;

            User::query()->where('id', auth()->user()->id)->update([
                'current_guess_streak' => 0,
                'credits' => $newUserCredits
            ]);

            // This we display the message for 10 seconds or something
            session()->flash('success', 'Je hebt een streak van 10 gehad, je krijgt nu een bonus!');
        }

        // TODO: Future paginate & make a the call with Queues
        // Get the all the games, normally you would like to paginate it, but we don't have time to do it
        $apiUrl = config('api.base_url');

        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/games');

        $games = json_decode($apiResponse);

        return view('dashboard', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        abort_if(!auth()->user()->is_admin, 403, 'Je hebt geen rechten om deze pagina te bezoeken.');

        $apiUrl = config('api.base_url');

        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/teams');

        $teams = json_decode($apiResponse);

        return view('admin.game.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGameRequest $request): RedirectResponse
    {
        $gameValidation = $request->safe()->only('dropdown_team1','dropdown_team2', 'game-date');
        $gameDate = date('Y-m-d H:i:s', strtotime($gameValidation['game-date']));

        if ($gameValidation['dropdown_team1'] == $gameValidation['dropdown_team2']) {
            return redirect()->back()->withErrors( 'Selecteer 2 verschillende teams');
        }

        $apiUrl = config('api.base_url');

        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '/games', [
            'team_id1' => $gameValidation['dropdown_team1'],
            'team_id2' => $gameValidation['dropdown_team2'],
            'game_date' => $gameDate,
        ]);

        if ($apiResponse->status() == 200) {
            return redirect()->back()->with( 'success', 'Wedstrijd aangemaakt!');
        }

        return redirect()->back()->withErrors( 'Er ging iets fout!');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @return Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
