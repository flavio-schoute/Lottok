<x-guest-layout>
    <x-header href="{{ route('login') }}">Inloggen</x-header>

    <x-jet-authentication-card>
        <x-slot name="logo">

        </x-slot>

        <x-jet-validation-errors class="mb-4"></x-jet-validation-errors>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-jet-label for="first_name" value="{{ __('Voornaam') }}"></x-jet-label>
                <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="last_name" value="{{ __('Achternaam') }}"></x-jet-label>
                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}"></x-jet-label>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Wachtwoord') }}"></x-jet-label>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Herhaal Wachtwoord') }}"></x-jet-label>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"></x-jet-input>
            </div>

            <div class="mt-4">
                <x-jet-label for="birth_date" value="{{ __('Geboortedatum') }}"></x-jet-label>
                <x-jet-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}" required></x-jet-input>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Registreren') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
