@extends('layouts.app')

@section('title', $task->title)

@section('content')

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

    <div class="max-w-2xl mx-auto">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $task->title }}
                </h1>
                <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full
                             {{ $statusColors[$task->status] ?? 'bg-gray-100' }}">
                    {{ $statusLabels[$task->status] ?? $task->status }}
                </span>
            </div>
            <div class="space-x-2">
                <a href="{{ route('tasks.edit', $task) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Редактировать
                </a>
                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">

            @if($task->description)
                <div class="mb-6">
                    <h2 class="text-sm font-medium text-gray-500 mb-2">Описание</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $task->description }}
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Назначено:</span>
                    <span class="ml-2 font-medium">
                        {{ $task->assignedUser->name ?? '—' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">Создал:</span>
                    <span class="ml-2">
                        {{ $task->creator->name ?? '—' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">Сделка:</span>
                    @if($task->deal)
                        <a href="{{ route('deals.show', $task->deal) }}"
                           class="ml-2 text-indigo-600 hover:underline">
                            {{ $task->deal->title }}
                        </a>
                    @else
                        <span class="ml-2 text-gray-400">—</span>
                    @endif
                </div>
                <div>
                    <span class="text-gray-500">Срок:</span>
                    <span class="ml-2
                        {{ $task->due_date && $task->due_date->isPast() && $task->status !== 'completed'
                            ? 'text-red-600 font-medium'
                            : '' }}">
                        {{ $task->due_date ? $task->due_date->format('d.m.Y') : '—' }}
                        @if($task->due_date && $task->due_date->isPast() && $task->status !== 'completed')
                            ⚠️ Просрочена
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-500">Создана:</span>
                    <span class="ml-2">{{ $task->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Обновлена:</span>
                    <span class="ml-2">{{ $task->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <form method="POST"
                      action="{{ route('tasks.destroy', $task) }}"
                      onsubmit="return confirm('Удалить задачу?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:underline text-sm">
                        Удалить задачу
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection
