

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h2 class="font-semibold md:text-5xl text-4xl text-indigo-800 leading-tight mb-10 sm:m-0 sm:mb-10 ml-5 mr-5">
                    {{ __('Statistieken') }}
                </h2>

                <div class="container flex flex-col">
                    <div class="p-6 m-20 bg-white rounded shadow">
                        {!! $incomechart->container() !!}
                    </div>
                    <script src="{{ $incomechart->cdn() }}"></script>
                    {{ $incomechart->script() }}

                    <div class="p-6 m-20 bg-white rounded shadow">
                        {!! $userbarchart->container() !!}
                    </div>
                    <script src="{{ $userbarchart->cdn() }}"></script>
                    {{ $userbarchart->script() }}
                    
                    <div class="p-6 m-20 bg-white rounded shadow">
                        {!! $topuserschart->container() !!}
                    </div>
                    <script src="{{ $topuserschart->cdn() }}"></script>
                    {{ $topuserschart->script() }}
                    
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
