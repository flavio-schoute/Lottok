<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Wedstrijd') }}
                </h2>

                <div class="container bg-white p-0 pb-5 shadow-md border-2 mt-10 flex flex-col items-center justify-center">

                    @if (session('success'))
                        <div class="bg-green-600 w-full h-20 flex items-center justify-center">
                            <ul class="text-xl text-white text-center">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any() || session('failed'))
                        <div class="bg-red-600 w-full h-20 flex flex-col items-center justify-center">
                            <div class="font-xl text-white">{{ __('Oeps! Er is iets fout gegaan.') }}</div>
                            <ul class="text-xl text-white text-center">
                                @if(session('failed'))
                                    <li>{{ session('failed') }}</li>
                                @endif
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif


                    <div class="title mt-12">
                        @foreach($games as $game)
                            <h2 class="text-4xl font-bold text-center">{{ $game->team_name1 }} VS {{ $game->team_name2 }}</h2>
                        @endforeach
                    </div>

                    <div class="standing mt-12">
                        @foreach($games as $game)
                            <h2 class="text-3xl font-bold text-center">STAND</h2>
                            <h2 class="text-3xl font-medium text-center mt-5">{{ $game->team1_score }} - {{ $game->team2_score }}</h2>
                        @endforeach
                    </div>

                    <form action="{{ route('gamble.store') }}" method="post" class="mt-10 flex flex-col items-center justify-center">
                        @if($user_gamble == 0)
                            @csrf
                        @endif

                        <div class="team_and_multiplier flex flex-col items-center justify-center">
                            @if($user_gamble == 0)
                                <label for="chosen_team">Selecteer winnende team</label><br>
                                <select name="chosen_team" class="text-center w-48">
                                    @foreach($games as $game)
                                        <option value="{{ $game->teamid1 }}">{{ $game->team_name1 }}</option>
                                        <option value="{{ $game->teamid2 }}">{{ $game->team_name2 }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <select class="hidden" name="game_id">
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $gameid }}</option>
                                @endforeach
                            </select>

                            @foreach($games as $game)
                                <p class="text-xl font-medium text-center mt-7">{{ $game->team_name1 }} - {{ $game->team_name2 }}</p>
                            @endforeach
                        </div>
                        @if($user_gamble == 0)
                        <div class="guess mt-10">
                            <label for="chosen_money">Selecteer gok bedrag</label><br>
                            <input type="text" name="chosen_money" class="w-48 h-20 text-2xl">
                        </div>
                        <button type="submit" name="submit" class="mt-10 border border-solid border-black w-48 h-20 hover:bg-indigo-900 hover:text-white">Plaats gok</button>
                        @endif
                    </form>

                    <form action="{{ route('gamble.destroy', $gameid) }}" method="POST" class="mt-10 flex flex-col items-center justify-center">
                        @if($user_gamble != 0)
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="mt-10 border border-solid border-black w-48 h-20 hover:bg-indigo-900 hover:text-white" onsubmit="return confirm('Weet je zeker dat je deze gok wilt verwijderen?');">Annuleer gok</button>
                        @endif
                    </form>

                    <div class="goks_geplaatst mt-14">
                        <table class="w-64">
                            <tr>
                                <th class="text-xl text-left">Aantal</th>
                                <th class="text-xl text-left">Team</th>
                            </tr>
                            @foreach($gambles as $gamble)
                                <tr>
                                    <td class="border">{{ $gamble->aantal }}</td>
                                    <td class="border">{{ $gamble->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
