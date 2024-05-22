<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $poll->name }} Inkesta egiten</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('front.store', ['polled' => $polled->id, 'poll' => $poll->id]) }}">                        
                    @csrf
                    @foreach ( $poll->question as $question )
                        <p>{{ $question->question }}</p>
                        <textarea name="answer[{{ $question->id }}]" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('answer' . $question->id) }}</textarea>
                        <x-input-error :messages="$errors->get('answer' . $question->id)" class="mt-2" /> 
                    @endforeach 
                    <x-primary-button class="mt-4">{{ __('Bidali') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>