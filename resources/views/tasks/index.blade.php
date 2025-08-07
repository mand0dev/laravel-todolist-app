<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Tareas') }}
            </h2>
            <button onclick="openCreateModal()" class="btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Tarea
            </button>
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
                                            <button onclick="openViewModal({{ $task->id }})" class="btn-primary bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                Ver
                                            </button>
                                            <button onclick="openEditModal({{ $task->id }})" class="btn-primary bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                Editar
                                            </button>
                                            <button onclick="openDeleteModal({{ $task->id }})" class="btn-danger bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">No tienes tareas creadas aún.</p>
                            <button onclick="openCreateModal()" class="btn-primary mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear tu primera tarea
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay Base para todos los modales -->
    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-45 hidden z-40 transition-opacity duration-300"></div>

    <!-- Modal para Ver Tarea -->
    <div id="viewModal" class="fixed inset-0 flex items-center justify-center hidden z-50 p-4">
        <div class="modal-shadow bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="viewModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Detalle de Tarea</h3>
                    <button onclick="closeViewModal()" class="btn-primary text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="viewTaskContent" class="mb-6">
                    <!-- Contenido se carga dinámicamente -->
                </div>
                <div class="flex justify-end border-t pt-4">
                    <button onclick="closeViewModal()" class="btn-primary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Tarea -->
    <div id="createModal" class="fixed inset-0 flex items-center justify-center hidden z-50 p-4">
        <div class="modal-shadow bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="createModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Nueva Tarea</h3>
                    <button onclick="closeCreateModal()" class="btn-primary text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="create_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título de la tarea *
                        </label>
                        <input type="text" 
                               id="create_title" 
                               name="title" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="Ingresa el título de tu tarea..."
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="create_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea id="create_description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Describe tu tarea (opcional)..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 border-t pt-4">
                        <button type="button" onclick="closeCreateModal()" class=" btn-primary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Crear Tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Tarea -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden z-50 p-4">
        <div class="modal-shadow bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="editModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Editar Tarea</h3>
                    <button onclick="closeEditModal()" class="btn-primary text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título de la tarea *
                        </label>
                        <input type="text" 
                               id="edit_title" 
                               name="title" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea id="edit_description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Describe tu tarea..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 border-t pt-4">
                        <button type="button" onclick="closeEditModal()" class="btn-primary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Actualizar Tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Eliminar Tarea -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50 p-4">
        <div class="modal-shadow bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.232 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Confirmar Eliminación</h3>
                    <p class="text-gray-600 mb-4">¿Desea realmente borrar esta tarea?</p>
                    <div class="bg-gray-50 rounded-lg p-3 mb-6">
                        <p id="deleteTaskTitle" class="font-semibold text-gray-800"></p>
                    </div>
                    
                    <div class="flex justify-center space-x-3">
                        <button onclick="closeDeleteModal()" class="btn-primary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Cancelar
                        </button>
                        <form id="deleteForm" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos de las tareas para JavaScript
        const tasks = @json($tasks);

        // Funciones de animación
        function showModal(modalId) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('div');
            
            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                overlay.classList.add('opacity-100');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function hideModal(modalId) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('div');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            overlay.classList.remove('opacity-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');
            }, 300);
        }

        // Modal Ver Tarea
        function openViewModal(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (!task) return;

            const content = `
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-3xl">${task.completed ? '✅' : '⭕'}</span>
                        <span class="text-status inline-flex items-center px-4 py-2 rounded-full text-sm font-medium ${task.completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${task.completed ? 'Completada' : 'Pendiente'}
                        </span>
                    </div>
                    
                    <div>
                        <h4 class="text-2xl font-bold ${task.completed ? 'line-through text-gray-500' : 'text-gray-900'}">${task.title}</h4>
                    </div>
                    
                    ${task.description ? `
                        <div>
                            <h5 class="font-semibold text-gray-700 mb-3">Descripción:</h5>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="leading-relaxed ${task.completed ? 'line-through text-gray-500' : 'text-gray-800'}">${task.description}</p>
                            </div>
                        </div>
                    ` : ''}
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <strong class="text-blue-800">Creada:</strong><br>
                            <span class="text-blue-600">${new Date(task.created_at).toLocaleDateString('es-ES')}</span><br>
                            <span class="text-blue-500 text-sm">${new Date(task.created_at).toLocaleTimeString('es-ES')}</span>
                        </div>
                        
                        ${task.completed && task.completed_at ? `
                            <div class="bg-green-50 p-4 rounded-lg">
                                <strong class="text-green-800">Completada:</strong><br>
                                <span class="text-green-600">${new Date(task.completed_at).toLocaleDateString('es-ES')}</span><br>
                                <span class="text-green-500 text-sm">${new Date(task.completed_at).toLocaleTimeString('es-ES')}</span>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;

            document.getElementById('viewTaskContent').innerHTML = content;
            showModal('viewModal');
        }

        function closeViewModal() {
            hideModal('viewModal');
        }

        // Modal Crear Tarea
        function openCreateModal() {
            document.getElementById('create_title').value = '';
            document.getElementById('create_description').value = '';
            showModal('createModal');
            // Focus en el primer campo
            setTimeout(() => {
                document.getElementById('create_title').focus();
            }, 350);
        }

        function closeCreateModal() {
            hideModal('createModal');
        }

        // Modal Editar Tarea
        function openEditModal(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (!task) return;

            document.getElementById('edit_title').value = task.title;
            document.getElementById('edit_description').value = task.description || '';
            document.getElementById('editForm').action = `/tasks/${task.id}`;
            showModal('editModal');
            // Focus en el primer campo
            setTimeout(() => {
                document.getElementById('edit_title').focus();
            }, 350);
        }

        function closeEditModal() {
            hideModal('editModal');
        }

        // Modal Eliminar Tarea
        function openDeleteModal(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (!task) return;

            document.getElementById('deleteTaskTitle').textContent = `"${task.title}"`;
            document.getElementById('deleteForm').action = `/tasks/${task.id}`;
            showModal('deleteModal');
        }

        function closeDeleteModal() {
            hideModal('deleteModal');
        }

        // Cerrar modales con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeViewModal();
                closeCreateModal();
                closeEditModal();
                closeDeleteModal();
            }
        });

        // Cerrar modales al hacer clic en el overlay
        document.getElementById('modalOverlay').addEventListener('click', function() {
            closeViewModal();
            closeCreateModal();
            closeEditModal();
            closeDeleteModal();
        });
    </script>

    <style>
        /* Estilos adicionales para las animaciones */
        .transition-all {
            transition: all 0.3s ease;
        }
        
        .transition-opacity {
            transition: opacity 0.3s ease;
        }
        
        .transition-colors {
            transition: color 0.2s ease, background-color 0.2s ease;
        }
        
        /* Scrollbar personalizado para los modales */
        .max-h-\[90vh\]::-webkit-scrollbar {
            width: 6px;
        }
        
        .max-h-\[90vh\]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .max-h-\[90vh\]::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</x-app-layout>

