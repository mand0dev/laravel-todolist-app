<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Tarea') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.show', $task) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ver Detalle
                </a>
                <a href="{{ route('tasks.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver a Lista
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la tarea actual -->
            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">
                            @if($task->completed)
                                ✅
                            @else
                                ⭕
                            @endif
                        </span>
                        <div>
                            <p class="text-sm text-gray-600">Editando tarea creada el
                                {{ $task->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-sm {{ $task->completed ? 'text-green-600' : 'text-yellow-600' }}">
                                Estado: {{ $task->completed ? 'Completada' : 'Pendiente' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título de la tarea *
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                placeholder="Describe tu tarea...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información adicional -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Información Adicional</h4>
                            <div class="text-sm text-blue-700 space-y-1">
                                <p><strong>Creada:</strong> {{ $task->created_at->format('d/m/Y H:i') }}</p>
                                @if($task->updated_at != $task->created_at)
                                    <p><strong>Última modificación:</strong> {{ $task->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                                @if($task->completed && $task->completed_at)
                                    <p><strong>Completada:</strong> {{ $task->completed_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Tarea
                            </button>
                            <a href="{{ route('tasks.show', $task) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Acciones adicionales -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Adicionales</h3>
                    <div class="flex flex-wrap gap-3">
                        @if(!$task->completed)
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                                    Marcar como Completada
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded text-sm">
                                    Marcar como Pendiente
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                                Eliminar Tarea
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>