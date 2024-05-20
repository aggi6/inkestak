<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Galdera aldatu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>{{ $question->poll->name }}</h1>
                    <br>
                    <form method="POST" action="{{ route('questions.update', $question) }}">
                    @csrf
                    @method('PATCH')
                        <p>Galdera</p>
                        <textarea name="question" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('question', $question->question) }}</textarea>
                        <x-input-error :messages="$errors->get('question')" class="mt-2" />
                        <br>
                        <x-primary-button class="mt-4">{{ __('Aldatu') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
