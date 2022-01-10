<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10">
                    {{ __('Geld storten') }}
                </h2>

                @if ($errors->any())
                    <div class="bg-red-600 w-full h-20 flex flex-col items-center justify-center">
                        <div class="font-xl text-white">{{ __('Oeps! Er is iets fout gegaan.') }}</div>
                        <ul class="text-xl text-white text-center">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <p>Kies bedrag</p>
                </div>

                <form action="{{ route('pay.store') }}" method="POST">
                    @csrf

                    <div class="drie-big box">

                        <div>
                            Box 1
                            <input type="hidden" readonly>
                        </div>

                        <div>
                            Box 2
                            <input type="hidden">
                        </div>

                        <div>
                            Box 3
                            <input type="hidden">
                        </div>
                    </div>

                    <p>Andere bedrag</p>

                    <label for="other-amount">
                        <input type="text" name="other-amount" id="other-amount" required>
                    </label>

                    <x-jet-button>Betalen</x-jet-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
