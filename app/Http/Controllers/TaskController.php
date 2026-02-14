<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Список всех задач
     * GET /tasks
     */
    public function index()
    {
        $tasks = Task::with(['deal', 'assignedUser'])
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Форма создания задачи
     * GET /tasks/create
     */
    public function create(Request $request)
    {
        $deals = Deal::orderBy('title')->get();
        $users = User::role('manager')->orRole('admin')->get();

        // Если передан deal_id - предзаполним
        $selectedDeal = $request->deal_id
            ? Deal::find($request->deal_id)
            : null;

        return view('tasks.create', compact('deals', 'users', 'selectedDeal'));
    }

    /**
     * Сохранить задачу
     * POST /tasks
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id'     => 'nullable|exists:deals,id',
            'assigned_to' => 'required|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
        ]);

        // Автоматически добавляем создателя
        $validated['created_by'] = auth()->id();

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Задача успешно создана!');
    }

    /**
     * Просмотр задачи
     * GET /tasks/{task}
     */
    public function show(Task $task)
    {
        $task->load(['deal', 'assignedUser', 'creator']);

        return view('tasks.show', compact('task'));
    }

    /**
     * Форма редактирования задачи
     * GET /tasks/{task}/edit
     */
    public function edit(Task $task)
    {
        $deals = Deal::orderBy('title')->get();
        $users = User::role('manager')->orRole('admin')->get();

        return view('tasks.edit', compact('task', 'deals', 'users'));
    }

    /**
     * Обновить задачу
     * PUT /tasks/{task}
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'deal_id'     => 'nullable|exists:deals,id',
            'assigned_to' => 'required|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Задача обновлена!');
    }

    /**
     * Удалить задачу
     * DELETE /tasks/{task}
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Задача удалена!');
    }
}
