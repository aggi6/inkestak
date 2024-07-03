<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Galdera berria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>{{ $poll->name }}</h1>
                    <br>
                    <form method="POST" action="{{ route('questions.store', $poll) }}">
                        @csrf
                        <p>Mota</p>
                        <select id="questionType" name="type" onchange="toggleOptions()">
                            <option value="{{ App\Http\Classes\QuestionType::OPEN }}">Irekia</option>
                            <option value="{{ App\Http\Classes\QuestionType::CLOSE }}" {{ old('type') == App\Http\Classes\QuestionType::CLOSE ? 'selected' : '' }}>Itxia</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        <div id="answerOptions" style="display: none;">
                            <button type="button" onclick="createOption()"
                                class="flex items-center space-x-2 px-4 py-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <div id="options" class="mt-4 space-y-4">
                                @if (old('options'))
                                    @foreach (old('options') as $index => $option)
                                        <div>
                                            <textarea name="options[{{ $index }}]" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ $option }}</textarea>
                                            <x-input-error :messages="$errors->get('options.' . $index)" class="mt-2" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <p>Galdera</p>
                        <textarea name="question"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('question') }}</textarea>
                        <x-input-error :messages="$errors->get('question')" class="mt-2" />
                        <br>
                        <x-primary-button class="mt-4">{{ __('Sortu') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleOptions();
        });

        function toggleOptions() {
            const questionType = document.getElementById('questionType').value;
            const answerOptions = document.getElementById('answerOptions');
            if (questionType === '{{ App\Http\Classes\QuestionType::CLOSE }}') {
                answerOptions.style.display = 'block';
            } else {
                answerOptions.style.display = 'none';
            }
        }

        function createOption() {
            const optionsDiv = document.getElementById('options');
            const index = optionsDiv.children.length;
            const optionDiv = document.createElement('div');
            const optionInput = document.createElement('textarea');
            optionInput.name = `options[${index}]`;
            optionInput.className = 'block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm';
            const optionError = document.createElement('div');
            optionError.innerHTML = `<x-input-error :messages="$errors->get('options.${index}')" class="mt-2" />`;
            optionDiv.appendChild(optionInput);
            optionDiv.appendChild(optionError);
            optionsDiv.appendChild(optionDiv);
        }
    </script>
</x-app-layout>
