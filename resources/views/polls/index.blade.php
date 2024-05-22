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
                        <h1 class="text-xl font-semibold underline">{{ $poll->name }} - {{ $poll->date }}</h1>
                        <ul>
                            @foreach ($poll->question as $question)
                                <li class="text-2xl">- {{ $question->question }} </li>
                                <li> {{ $question->poll->id }}</li>
                                <a href="{{ route('questions.edit', $question) }}"><font color="green"> Aldatu galdera</font></a>
                                <form method="POST" action="{{ route('questions.destroy', $question) }}">
                                    @csrf
                                    @method('delete')
                                    <button><font color="red">Ezabatu galdera</font></button>
                                </form>
                            @endforeach
                        </ul>
                        <br>
                        <a href="{{ route('questions.create', $poll) }}"><font color="green">Sortu galdera berria</font></a>
                        <form method="POST" action="{{ route('polls.destroy', $poll) }}">
                            @csrf
                            @method('delete')
                            <button><font color="red">Ezabatu inkesta</font></button>
                        </form>
                        <a href="{{ route('polls.edit', $poll) }}"><font color="green">Aldatu inkesta</font></a>
                        <h1>__________________________________________________</h1>
                        <br>
                    @endforeach
                    <br>
                    <a href="{{ route('polls.create') }}">Sortu inkesta berria</a><br>
                    <a href="{{ route('polls.trash') }}">Zaborra</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
