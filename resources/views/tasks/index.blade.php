@extends('layouts.app')

@section('title', 'Задачи')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Задачи</h1>
        <a href="{{ route('tasks.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Новая задача
        </a>
    </div>

    @php
        $statusColors = [
            'pending'     => 'bg-gray-100 text-gray-700',
            'in_progress' => 'bg-blue-100 text-blue-700',
            'completed'   => 'bg-green-100 text-green-700',
        ];
        $statusLabels = [
            'pending'     => 'Ожидает',
            'in_progress' => 'В работе',
            'completed'   => 'Завершена',
        ];
    @endphp

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Задача</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сделка</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Назначено</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Срок</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($tasks as $task)
                <tr class="hover:bg-gray-50
                               {{ $task->status === 'completed' ? 'opacity-60' : '' }}">
                    <td class="px-6 py-4">
                        <a href="{{ route('tasks.show', $task) }}"
                           class="text-indigo-600 hover:underline font-medium">
                            {{ $task->title }}
                        </a>
                        @if($task->description)
                            <p class="text-gray-400 text-xs mt-1 truncate max-w-xs">
                                {{ $task->description }}
                            </p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        @if($task->deal)
                            <a href="{{ route('deals.show', $task->deal) }}"
                               class="hover:underline">
                                {{ $task->deal->title }}
                            </a>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $task->assignedUser->name ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                         {{ $statusColors[$task->status] ?? 'bg-gray-100' }}">
                                {{ $statusLabels[$task->status] ?? $task->status }}
                            </span>
                    </td>
                    <td class="px-6 py-4 text-sm
                                   {{ $task->due_date && $task->due_date->isPast() && $task->status !== 'completed'
                                       ? 'text-red-600 font-medium'
                                       : 'text-gray-600' }}">
                        {{ $task->due_date ? $task->due_date->format('d.m.Y') : '—' }}
                        @if($task->due_date && $task->due_date->isPast() && $task->status !== 'completed')
                            <span class="text-xs">⚠️</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('tasks.edit', $task) }}"
                           class="text-yellow-600 hover:underline text-sm">
                            Изменить
                        </a>
                        <form method="POST"
                              action="{{ route('tasks.destroy', $task) }}"
                              class="inline"
                              onsubmit="return confirm('Удалить задачу?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:underline text-sm">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"
                        class="px-6 py-10 text-center text-gray-400">
                        Задач пока нет
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>

@endsection
