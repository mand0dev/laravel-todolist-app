<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TodoList App</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ route('tasks.index') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Mis Tareas</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-6xl font-bold text-gray-900">TodoList App</h1>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 ring-1 ring-inset ring-white/5 transition-all duration-250 focus:outline-none focus-visible:ring-[#FF2D20]">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Organiza tus tareas</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Crea, edita y organiza todas tus tareas diarias de manera sencilla. Mantén el control de lo que necesitas hacer.
                                </p>
                            </div>
                        </div>

                        <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 ring-1 ring-inset ring-white/5 transition-all duration-250 focus:outline-none focus-visible:ring-[#FF2D20]">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Marca como completadas</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Experimenta la satisfacción de marcar tus tareas como completadas y ver tu progreso diario.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-16">
                    @auth
                        <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg">
                            Ver mis tareas
                        </a>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg text-lg">
                                Registrarse
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>