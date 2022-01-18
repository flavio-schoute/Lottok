<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Wedstrijd') }}
                </h2>

                @if ($errors->any())
                    <div class="mt-5 text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
                            <span class="text-xl inline-block mr-5 align-middle">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                            </span>
                        <span class="inline-block align-middle mr-8">
                                <b class="capitalize">Oeps! Er is iets fout gegaan!</b>
                                @foreach ($errors->all() as $error)
                                <p>&#8594; {{ $error }}</p>
                            @endforeach
                            </span>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="mt-5  text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-600">
                          <span class="text-xl inline-block mr-5 align-middle">
                              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                          </span>
                        <span class="inline-block align-middle mr-8">
                            <b class="capitalize">Gefeliciteerd!</b>
                            {{ session()->get('success') }}
                        </span>
                    </div>
                @endif

                <div class="container bg-white p-0 pb-5 shadow-md border-1 mt-10 flex flex-col items-center justify-center">

                    <div class="mt-8 text-center">
                        <h2 class="text-3xl font-bold">{{ $games->data->team_name1 }} VS {{ $games->data->team_name1 }}</h2>
                    </div>

                    <div class="mt-5 text-center">
                        <h2 class="text-2xl font-bold">Stand</h2>
                        <p class="text-2xl mt-3">{{ $games->data->team1_score }} - {{ $games->data->team2_score }}</p>
                    </div>

                    <div class="mt-5 text-center">
                        <h2 class="text-2xl font-bold">Wedstrijd datum</h2>
                        <p class="text-xl mt-3">{{ date('d-m-Y H:i', strtotime($games->data->game_date)) }}</p>
                    </div>

                    <div class="mt-5 text-center">
                        <form action="{{ route('gamble.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="game_id" value="{{ $games->data->id}}" readonly>
                            @if ($foundedGamble->isEmpty())
                                <div class="mb-3">
                                    <x-jet-label for="chosen_team" value="{{ __('Selecteer het winnende team') }}" class="pb-2"></x-jet-label>
                                    <select name="chosen_team" id="chosen_team">
                                        <option value="{{ $games->data->team_id1 }}">{{ $games->data->team_name1 }}</option>
                                        <option value="{{ $games->data->team_id2 }}">{{ $games->data->team_name2 }}</option>
                                    </select>
                                </div>

                                
                                    <x-jet-label for="chosen_team" value="{{ __('Selecteer gok bedrag') }}" class="pb-2"></x-jet-label>
                                    <x-jet-input id="chosen_team" class="block mt-1 w-full" type="text" name="chosen_money" :value="old('chosen_money')"></x-jet-input>
                                </div>

                                <livewire:place-bet/>
                            @endif

                        </form>
                    </div>

                    @if (!$foundedGamble->isEmpty())
                    <div class="mt-5 text-center">
                        <h3 class="text-3xl my-5">Gegokt bedrag</h3>
                        <h3 class="text-4xl my-5">€{{ $foundedGamble->first()->bet_credit }}</h3>
                    </div>

                        <form action="{{ route('gamble.destroy', $foundedGamble->first()->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <livewire:remove-bet/>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
