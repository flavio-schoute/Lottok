{{--<form action="{{ route('cashout.index') }}" method="POST">--}}
{{--        @csrf--}}
{{--        @method('DELETE')--}}

{{--    <x-jet-button class="mt-5" onclick="return confirm('Weet je zeker dat je deze gok wilt verwijderen?');">--}}
{{--        {{ __('Annuleer gok') }}--}}
{{--    </x-jet-button>--}}
{{--</form>--}}


<x-jet-button class="mt-5" onclick="return confirm('Weet je zeker dat je deze gok wilt verwijderen?');">
    {{ __('Annuleer gok') }}
</x-jet-button>

