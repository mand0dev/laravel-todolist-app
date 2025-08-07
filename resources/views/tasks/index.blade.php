<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Tareas') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Tarea
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Estadísticas -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold">Total de Tareas</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $tasks->count() }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold">Completadas</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $tasks->where('completed', true)->count() }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900">
                        <h3 class="text-lg font-semibold">Pendientes</h3>
                        <p class="text-3xl font-bold text-red-600">{{ $tasks->where('completed', false)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Lista de tareas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($tasks as $task)
                                <div class="border rounded-lg p-4 {{ $task->completed ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200' }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <!-- Toggle completado -->
                                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-2xl">
                                                    @if($task->completed)
                                                        ✅
                                                    @else
                                                        ⭕
                                                    @endif
                                                </button>
                                            </form>
                                            
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                                    {{ $task->title }}
                                                </h3>
                                                @if($task->description)
                                                    <p class="text-gray-600 {{ $task->completed ? 'line-through' : '' }}">
                                                        {{ Str::limit($task->description, 100) }}
                                                    </p>
                                                @endif
                                                <div class="text-sm text-gray-500 mt-2">
                                                    <span>Creada: {{ $task->created_at->format('d/m/Y H:i') }}</span>
                                                    @if($task->completed && $task->completed_at)
                                                        <span class="ml-4">Completada: {{ $task->completed_at->format('d/m/Y H:i') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Botones de acción -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                Ver
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                Editar
                                            </a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">No tienes tareas creadas aún.</p>
                            <a href="{{ route('tasks.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear tu primera tarea
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>