<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10">
                    {{ __('Geld storten') }}
                </h2>

                @if ($errors->any())
                    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
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

                @if((request()->get('succes') == 'true' && request()->get('amount')) || session('succes'))
                    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-600">
                          <span class="text-xl inline-block mr-5 align-middle">
                              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                          </span>
                        <span class="inline-block align-middle mr-8">
                            <b class="capitalize">Gefeliciteerd!</b>
                            <p>De betaling van {{ request()->get('amount') }} euro is geslaagd!</p>
                        </span>
                    </div>
                @endif

                <div class="text-xl text-gray-700 font-semibold">
                    <p>Kies bedrag</p>
                    <p>1 credit = 1 euro </p>
                </div>

                <form action="{{ route('pay.store') }}" method="POST">
                    @csrf

                    <div class="inline-flex mt-5">

                        <div class="flex justify-center mr-8">
                            <div class="max-w-sm bg-white border-2 border-gray-300 p-6 rounded-md tracking-wide shadow-lg hover:bg-gray-300">
                                <div class="font-semibold">
                                    <p class="text-gray-600">5 credits</p>
                                </div>

                                <label class="flex justify-center" for="amount-5">
                                    <input name="amount-5" readonly value="5"  id="boxes" onclick="onlyOne(this)" class="text-indigo-500 w-8 h-8 focus:ring-indigo-400 focus:ring-opacity-25 border border-gray-300 rounded" type="checkbox" />
                                </label>
                            </div>

                        </div>

                        <div class="flex justify-center mr-8">
                            <div class="max-w-sm bg-white border-2 border-gray-300 p-6 rounded-md tracking-wide shadow-lg hover:bg-gray-300">
                                <div class="font-semibold">
                                    <p class="text-gray-600">10 credits</p>
                                </div>

                                <label class="flex justify-center" for="amount-10">
                                    <input name="amount-10" id="boxes" readonly value="10" onclick="onlyOne(this)" class="text-indigo-500 w-8 h-8 focus:ring-indigo-400 focus:ring-opacity-25 border border-gray-300 rounded" type="checkbox" />
                                </label>
                            </div>

                        </div>

                        <div class="flex justify-center mr-8">
                            <div class="max-w-sm bg-white border-2 border-gray-300 p-6 rounded-md tracking-wide shadow-lg hover:bg-gray-300">
                                <div class="font-semibold">
                                    <p class="text-gray-600">20 credits</p>
                                </div>


                                <label class="flex justify-center" for="amount-20">
                                    <input name="amount-20" value="20"  id="boxes" readonly onclick="onlyOne(this)" class="text-indigo-500 w-8 h-8 focus:ring-indigo-400 focus:ring-opacity-25 border border-gray-300 rounded" type="checkbox" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="other-amount" class="block text-sm font-medium text-gray-700">Ander aantal credits:</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="other-amount" id="other-amount"
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md"
                                   placeholder="50">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-jet-button class="mt-5">Betalen</x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  We write the script here because if we do it in main JS file, the script will be in every page and that is not what we want  --}}
    @once
        @push('pay-script')
            <script>
                let checkBoxes = document.querySelectorAll('input[type="checkbox"]');
                let textFieldInput = document.getElementById('other-amount');

                // Credits to Reinout Wijnholds (StackOverFlow)
                function onlyOne(checkbox) {
                    checkBoxes.forEach((item) => {
                        if (item !== checkbox) item.checked = false
                    })
                }

                for(let box of checkBoxes) {
                    box.addEventListener('change', function() {
                        textFieldInput.disabled = box.checked;
                        textFieldInput.value = "";
                    })
                }
            </script>
        @endpush
    @endonce

</x-app-layout>
