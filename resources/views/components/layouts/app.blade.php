<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'POC : TODO APP') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-sky-50 text-gray-800">

    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Todo App</h1>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    Se déconnecter
                </button>
            </form>
        @endauth
    </header>

    {{ $slot }}

    @livewireScripts
</body>
</html>
