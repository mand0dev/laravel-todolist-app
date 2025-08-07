<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Tarea') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.edit', $task) }}"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('tasks.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Información principal de la tarea -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Estado y acciones -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-4xl hover:scale-110 transition-transform">
                                    @if($task->completed)
                                        ✅
                                    @else
                                        ⭕
                                    @endif
                                </button>
                            </form>

                            <div>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $task->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $task->completed ? 'Completada' : 'Pendiente' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                                Editar
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Título -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 {{ $task->completed ? 'line-through' : '' }}">
                            {{ $task->title }}
                        </h1>
                    </div>

                    <!-- Descripción -->
                    @if($task->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Descripción</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-800 leading-relaxed {{ $task->completed ? 'line-through' : '' }}">
                                    {{ $task->description }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Información de fechas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Fecha de Creación</h4>
                            <p class="text-blue-600">{{ $task->created_at->format('d/m/Y') }}</p>
                            <p class="text-blue-500 text-sm">{{ $task->created_at->format('H:i') }}</p>
                        </div>

                        @if($task->updated_at != $task->created_at)
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-yellow-800 mb-2">Última Modificación</h4>
                                <p class="text-yellow-600">{{ $task->updated_at->format('d/m/Y') }}</p>
                                <p class="text-yellow-500 text-sm">{{ $task->updated_at->format('H:i') }}</p>
                            </div>
                        @endif

                        @if($task->completed && $task->completed_at)
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-green-800 mb-2">Fecha de Completado</h4>
                                <p class="text-green-600">{{ $task->completed_at->format('d/m/Y') }}</p>
                                <p class="text-green-500 text-sm">{{ $task->completed_at->format('H:i') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Información adicional -->
                    @if($task->completed && $task->completed_at)
                        <div class="mt-6 p-4 bg-green-100 border-l-4 border-green-500">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        <strong>¡Tarea completada!</strong>
                                        Tiempo transcurrido desde la creación:
                                        {{ $task->created_at->diffForHumans($task->completed_at, true) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Rápidas</h3>
                    <div class="flex flex-wrap gap-3">
                        @if(!$task->completed)
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                                    Marcar como Completada
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded">
                                    Marcar como Pendiente
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('tasks.edit', $task) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Editar Tarea
                        </a>

                        <a href="{{ route('tasks.create') }}"
                            class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded">
                            Crear Nueva Tarea
                        </a>

                        <a href="{{ route('tasks.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Ver Todas las Tareas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>