<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ua</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Georgia&display=swap');
        .font-georgia {
            font-family: 'Georgia', serif;
        }
        .font-consolas {
            font-family: 'Consolas', 'mono';
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-200">
    <div class="bg-gray-100 h-auto w-2/12 p-4 flex flex-col space-y-4">
        <div class="bg-green-300 cursor-help origin-top-left text-black p-8 border-black rounded-2xl border-t-4 font-consolas">Div berde</div>
        <div class="bg-red-500 cursor-wait p-8 uppercase font-thin border-black border-r-4 shadow-md flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0a12 12 0 00-12 12h4zm12-8a8 8 0 01-8 8v4a12 12 0 0012-12h-4z"></path>
            </svg>
            <span>Div gorria</span>
        </div>
        <div class="bg-blue-500 p-20 w-1/2 tracking-widest shadow-2xl border-black border-l-4 h-96">Div urdina</div>
    </div>
    <div class="w-1/2 bg-pink-200 p-4 flex flex-col space-y-4">
        <div class="bg-blue-200 p-10 shadow-2xl font-black italic self-end">Div urdin argia</div>
        <div class="bg-red-300 p-8 capitalize font-serif border-8 shadow-[#FFFF00] shadow-inner border-dotted">Div gorri argia</div>
        <div class="bg-black text-white tracking-tighter h-10 text-center font-georgia w-1/2 mx-auto rounded-full flex items-center justify-center hover:opacity-100 opacity-70 transition-opacity duration-300">Div beltza</div>
    </div>
    <div class="relative">
        <button id="dropdownButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none">Menua</button>
        <div id="dropdownMenu" class="absolute top-full right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
            <div class="py-2">
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:outline-none" onclick="toggleContent('content1')">a</button>
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:outline-none" onclick="toggleContent('content2')">b</button>
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:outline-none" onclick="toggleContent('content3')">c</button>
            </div>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
