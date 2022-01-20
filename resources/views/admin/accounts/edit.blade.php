<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto flex justify-center">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Wijzig account') }}
                </h2>
            </div>
        </div>
    </div>

    <div class="py-6 max-w-7xl mx-auto flex justify-center">
        <div class="w-96 bg-white p-10 py-5 rounded-md">

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

            <form action="{{ route('admin.accounts.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}" readonly>

                <div class="mt-4">
                    <x-jet-label for="first_name" value="{{ __('Voornaam') }}"></x-jet-label>
                    <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$user->first_name"></x-jet-input>
                </div>

                <div class="mt-4">
                    <x-jet-label for="last_name" value="{{ __('Achternaam') }}"></x-jet-label>
                    <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name"></x-jet-input>
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}"></x-jet-label>
                    <x-jet-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$user->email"></x-jet-input>
                </div>


                <div class="mt-4">
                    <x-jet-label for="birth_date" value="{{ __('Geboortedatum') }}"></x-jet-label>
                    <x-jet-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="date('Y-m-d', strtotime($user->birth_date))" max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}" required></x-jet-input>
                </div>

                <div class="mt-4">
                    <x-jet-label for="is_admin" value="{{ __('Role') }}"></x-jet-label>
                    <select class="w-full" name="is_admin">
                        <option value="0">Klant</option>
                        <option value="1" {{ $user->is_admin ? 'selected' : ''}}>Admin</option>
                    </select>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-jet-button>
                        {{ __('Wijzigen') }}
                    </x-jet-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
