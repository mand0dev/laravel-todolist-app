<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TodoList App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100">

    <style>
        :root {
            --primary-blue: #033DFF;
            --hover-gray: #1C1C1C;
            --dark-bg: #0F172A;
            --dark-card: #1E293B;
            --dark-border: #334155;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            margin-left: .2em;
            margin-right: .2em;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background-color: #C71A1A;
            color: white;
            transition: all 0.3s ease;
        }

        input,
        textarea,
        .text-status {
            color: #1c1c1cbe;
        }

        .modal-shadow {
            box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .text-pending {
            color: #FFAC00;
        }

        .text-completed {
            color: #28C71A;
        }

        .text-incompleted {
            color: #C71A1A;
        }

        .btn-primary:hover {
            background-color: var(--hover-gray);
            color: white;
        }

        .btn-danger:hover {
            background-color: #0F172A;
            color: white;
            transition: all 0.3s ease;
        }
    </style>

    <!-- Menú de navegación -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                        TodoList App
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-gray-900">
                            Mis Tareas
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary text-red-600 hover:text-red-800">
                                Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary text-gray-700 hover:text-gray-900">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary text-gray-700 hover:text-gray-900">
                                Registro
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

</body>

</html>