<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    use AuthorizesRequests; // Use authorize
    
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
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

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
        $this->authorize('delete', $task);
        
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

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
