<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Wedstrijd aanmaken') }}
                </h2>

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

                <div class="container bg-white p-0 pb-5 shadow-md border-2 mt-10 flex flex-col items-center justify-center">

                    <form class="mt-10" method="post" action="{{ route('games.store') }}">
                        @csrf
                        <div class="flex flex-row justify-evenly">

                            <select class="rounded-xl" name="dropdown_team1">
                                @foreach($teams->data as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <h4>VS</h4>
                            <select class="rounded-xl" name="dropdown_team2">
                                @foreach($teams->data as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-row mt-10 items-center">
                            <x-jet-label for="game-date" value="{{ __('Datum wedstrijd') }}" class="text-lg text-left inline-block w-64"></x-jet-label>
                            <x-jet-input id="game-date" class="block mt-1 w-full" type="datetime-local" name="game-date"></x-jet-input>
                        </div>

                        <div class="flex items-end justify-end mt-10">
                            <x-jet-button>
                                {{ __('Maak wedstrijd aan') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
