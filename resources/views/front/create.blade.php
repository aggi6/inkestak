<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $poll->name }} Inkesta egiten</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ( $poll->question as $question )
                        <form method="POST" action="{{ route('front.store', ['polled' => $polled->id, 'poll' => $poll->id, 'question' => $question->id]) }}">                        
                        @csrf
                            <p>{{ $question->question }}</p>
                            <textarea name="answer" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('answer') }}</textarea>
                            <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                            <x-primary-button class="mt-4">{{ __('Bidali') }}</x-primary-button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>