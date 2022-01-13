<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Account wijzigen') }}
                </h2>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
                    <span class="inline-block align-middle mr-8">
                        <b class="capitalize italic block mb-2">Whooops!</b>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                </div>
            @endif

            <form action="{{ route('accounts.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="role_id" value="{{$user->role_id}}">

                <div class="mt-4">
                    <x-jet-label for="first_name" value="{{ __('Voornaam') }}"/>
                    <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$user->first_name"/>
                </div>

                <div class="mt-4">
                    <x-jet-label for="last_name" value="{{ __('Achternaam') }}"/>
                    <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name"/>
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}"/>
                    <x-jet-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$user->email"/>
                </div>

                <div class="mt-4">
                    <x-jet-label for="birthdate" value="{{ __('Geboortedatum') }}"/>
                    <x-jet-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="date('d/m/Y', strtotime($user->birth_date))"/>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-jet-button>
                        {{ __('Bewerking opslaan') }}
                    </x-jet-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
