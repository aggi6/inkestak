<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inkestak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($polls as $poll)
                        <h1>{{ $poll->name }} - {{ $poll->date }}</h1>
                        <ul>
                            @foreach ($poll->question as $question)
                                <li>- {{ $question->question }}</li>
                            @endforeach
                        </ul>
                        <br><br>
                        <a href="{{ route('questions.create') }}">Sortu galdera berria</a>
                    @endforeach
                    <br><br>
                    <a href="{{ route('polls.create') }}">Sortu inkesta berria</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
