<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Erantzunak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($answers as $answer)
                        <h1>Inkesta: {{ $answer->poll->name }}</h1>
                        <h1>Inkestatua: {{ $answer->polled->name }}</h1>
                        <h1>Galdera: {{ $answer->question->question }}</h1> 
                        <h1>Erantzuna: {{ $answer->answer }}</h1>  
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
