<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zaborra') }}
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
                        <form method="POST" action="{{ route('polls.restore', $poll) }}">
                            @csrf
                            @method('PATCH')
                            <button>Berreskuratu inkesta</button>
                        </form>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
