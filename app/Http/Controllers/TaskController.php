<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Jobs\DeleteCompletedTask;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Cache simples sem tags
        return Cache::remember('tasks_all', 60, function () {
            return Task::whereNull('deleted_at')->orderByDesc('created_at')->get();
        });
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_limite' => 'nullable|date'
        ]);

        $task = Task::create($validated);
        Cache::forget('tasks_all'); // limpar cache específico
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return Cache::remember("task_{$task->id}", 60, fn () => $task);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'finalizado' => 'boolean',
            'data_limite' => 'nullable|date'
        ]);

        $task->update($validated);

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        Cache::forget('tasks_all');
        Cache::forget("task_{$task->id}");
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        Cache::forget('tasks_all');
        Cache::forget("task_{$task->id}");
        return response()->json(null, 204);
    }

    public function toggle(Task $task)
    {
        $task->update(['finalizado' => !$task->finalizado]);
        Cache::forget('tasks_all');
        Cache::forget("task_{$task->id}");

        if ($task->finalizado) {
            DeleteCompletedTask::dispatch($task)->delay(now()->addMinutes(10));
        }

        return response()->json($task);
    }
}