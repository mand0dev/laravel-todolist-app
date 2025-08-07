<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada exitosamente.');
    }

    public function show(Task $task): View
    {
        // Verificar que la tarea pertenece al usuario autenticado
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta tarea.');
        }
        
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        // Verificar que la tarea pertenece al usuario autenticado
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta tarea.');
        }
        
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        // Verificar que la tarea pertenece al usuario autenticado
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar esta tarea.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        // Verificar que la tarea pertenece al usuario autenticado
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta tarea.');
        }
        
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    public function toggle(Task $task): RedirectResponse
    {
        // Verificar que la tarea pertenece al usuario autenticado
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para modificar esta tarea.');
        }

        if ($task->completed) {
            $task->markAsIncomplete();
            $message = 'Tarea marcada como pendiente.';
        } else {
            $task->markAsCompleted();
            $message = 'Tarea completada.';
        }

        return redirect()->route('tasks.index')
            ->with('success', $message);
    }
}

