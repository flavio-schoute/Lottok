<x-guest-layout>
    <x-header href="{{ route('register') }}">Registeren</x-header>

    <x-jet-authentication-card>
        <x-slot name="logo">
            @if(session('account_inactive'))
                <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
                <span class="text-xl inline-block mr-5 align-middle">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                </span>
                    <span class="inline-block align-middle mr-8">
                    <strong class="capitalize">Oeps! Er is iets fout gegaan!</strong>
                        <p>&#8594; {{ session('account_inactive') }}</p>
                </span>
                </div>
            @endif
        </x-slot>

        <x-jet-validation-errors class="mb-4"></x-jet-validation-errors>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}"></x-jet-label>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Wachtwoord') }}"></x-jet-label>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"></x-jet-input>
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember"></x-jet-checkbox>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Mij onthouden') }}</span>
                </label>

                <x-jet-button class="ml-4 bg-indigo-600">
                    {{ __('Inloggen') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
