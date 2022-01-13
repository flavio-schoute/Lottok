<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Account overzicht') }}
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

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Voornaam
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Achternaam
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Geboorte datum
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rol
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Credits
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acties
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actief
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->first_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->last_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ date('d-m-Y', strtotime($user->birth_date)) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_admin)
                                                    Admin
                                                @else
                                                    Klant
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">&euro; {{ $user->credits }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.accounts.edit', $user->id) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>

                                                <form class="inline-block"
                                                      action="{{ route('admin.accounts.destroy', $user->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit"
                                                           class="text-red-600 hover:text-red-900 bg-transparent"
                                                           value="Verwijder">
                                                </form>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap">

                                                @inject('injectedModel', 'App\Models\User')

                                                <livewire:block-toggle-button
                                                    :model="$injectedModel"
                                                    field="is_active"
                                                    userID="{{ $user->id }}"
                                                />
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- Checken if dit werkt--}}
                                        <p>Geen gebruikers</p>
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="my-3">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
