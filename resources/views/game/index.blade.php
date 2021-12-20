<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Wedstrijd') }}
                </h2>
                <div class="container bg-white p-5 pt-12 shadow-md border-2 mt-10 flex flex-col items-center justify-center">

                    <div class="title">
                        @foreach($games as $game)
                            <h2 class="text-4xl font-bold text-center">{{ $game->name1 }} VS {{ $game->name2 }}</h2>
                        @endforeach
                    </div>

                    <div class="standing mt-12">
                    @foreach($games as $game)
                        <h2 class="text-3xl font-bold text-center">STAND</h2>
                        <h2 class="text-3xl font-medium text-center mt-5">4 - 1</h2>
                       @endforeach
                    </div>

                    <form action="{{ route('gamble.store') }}" method="post" class="mt-10 flex flex-col items-center justify-center">
                        @csrf

                        <div class="team_and_multiplier">
                            <label for="chosen_team">Selecteer winnende team</label><br>
                            <select name="chosen_team" class="text-center w-48">
                            @foreach($games as $game)
                                <option value="{{ $game->teamid1 }}">{{  $game->name1    }}</option>
                                <option value="{{ $game->teamid2 }}">{{ $game->name2 }}</option>
                            @endforeach
                            </select>
                            
                            <select class="hidden" name="gameid" class="text-center">
                            @foreach($games as $game)
                                <option value="{{ $gameid }}">{{  $gameid  }}</option>
                            @endforeach
                            </select>

                            @foreach($games as $game)
                              <p class="text-xl font-medium text-center mt-7">{{ $game->name1 }}    -      {{ $game->name2 }}</p>
                            @endforeach
                        </div>
                        <div class="guess mt-10">
                            <label for="chosen_money">Selecteer gok bedrag</label><br>
                            <input type="text" name="chosen_money" class="w-48 h-20 text-2xl">
                        </div>  
                        <button type="submit" name="submit" class="mt-10 border border-solid border-black w-48 h-20 hover:bg-indigo-900 hover:text-white">Plaats gok</button>

                    </form>


                    <div class="goks_geplaatst mt-14">
                        <table class="w-64">
                            <tr>
                              <th class="text-xl text-left">Aantal</th>
                              <th class="text-xl text-left">Team</th>
                            </tr>
                            @foreach($gambles as $gamble)
                            <tr>
                              <td>{{ $gamble->aantal }}</td>
                              <td>{{ $gamble->name }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
