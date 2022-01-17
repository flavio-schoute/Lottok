<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Goal;
use App\Models\Team;
use App\Models\Gamble;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
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
        $apiUrl = config('api.base_url');

        $apiResponse = Http::acceptJson()->withHeaders([
            'Content-Type' => 'application/json',
        ])->get($apiUrl . '/games');

//        dd(json_decode($apiResponse));

        $games = json_decode($apiResponse);

//        $data = $this->paginate($games);

//        dd($data);

//        $games = Game::query()
//            ->selectRaw('team1.name AS team_name1, team2.name AS team_name2, games.id, team1_score, team2_score, game_date')
//            ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
//            ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
//            ->orderBy('games.game_date')
//            ->paginate(9);
//
//        dd($games);

        return view('dashboard', compact(['games']));

//        $teams = Team::query()
//        ->selectRaw('*')
//        ->get();
//
//        return view('admin.gamble.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return Response
     */
    public function store(StoreGameRequest $request)
    {
        $gameValidation = $request->safe()->only('dropdown_team1','dropdown_team2', 'gamble-date');
        $gamedate = date('Y-m-d H:i:s', strtotime($gameValidation['gamble-date']));

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
     * @param Game $game
     * @return Response
     */
    public function show(Game $game)
    {
        $games = DB::table('games')
        ->select(DB::raw('team1.name AS name1, team2.name AS name2, games.game_date'))
        ->join('teams AS team1', 'games.team_id1', '=', 'team1.id')
        ->join('teams AS team2', 'games.team_id2', '=', 'team2.id')
        ->where('games.id', '=', $game->id)
        ->get();
        return view('gamble.index', compact('games'));
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
