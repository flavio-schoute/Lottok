<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10">
                    {{ __('Wedstrijden') }}
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
                    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-600">
                          <span class="text-xl inline-block mr-5 align-middle">
                              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                          </span>
                        <span class="inline-block align-middle mr-8">
                            <b class="capitalize">Gefeliciteerd!</b>
                            {{ session()->get('success') }}
                        </span>
                    </div>
                @endif

                <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-8 sm:m-0">

                    @foreach($games->data as $game)
                            @if (!Carbon\Carbon::parse($game->game_date)->isPast())
                                <a href="{{ route('gamble.show', $game->id) }}">
                                    <div id="{{ $game->id }}"
                                         class="bg-white h-60 flex flex-col justify-center items-center text-indigo-800 border-2 border-indigo-800 hover:bg-indigo-800 hover:text-white transition ease-in-out cursor-pointer">
                                        <h3 class="text-5xl font-medium">Wedstrijd</h3>
                                        <p class="text-2xl font-semibold mt-2">{{ $game->team_name1 }} VS {{ $game->team_name2 }}</p>
                                        <p class="text-base font-medium text-center mt-2">{{ date('d-m-Y', strtotime($game->game_date)) }}</p>
                                        <p class="text-base font-medium text-center mt-1">{{ date('H:i', strtotime($game->game_date)) }}</p>
                                    </div>
                                </a>
                            @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
