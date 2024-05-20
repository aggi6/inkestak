<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inkesta berria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('polls.store') }}">
                    @csrf
                        <p>Inkesta izena</p>
                        <textarea name="name" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('name') }}</textarea>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        <p>Data</p>
                        <input type="date" name="date" value="{{ old('date') }}"></input>
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        <br>
                        <x-primary-button class="mt-4">{{ __('Sortu') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
