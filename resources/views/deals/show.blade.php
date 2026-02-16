@extends('layouts.app')

@section('title', $deal->title)

@section('content')

    @php
        $statusColors = [
            'new'         => 'bg-gray-100 text-gray-700',
            'contacted'   => 'bg-blue-100 text-blue-700',
            'qualified'   => 'bg-yellow-100 text-yellow-700',
            'proposal'    => 'bg-purple-100 text-purple-700',
            'negotiation' => 'bg-orange-100 text-orange-700',
            'won'         => 'bg-green-100 text-green-700',
            'lost'        => 'bg-red-100 text-red-700',
        ];
        $statusLabels = [
            'new'         => 'Новая',
            'contacted'   => 'Контакт',
            'qualified'   => 'Квалифицирован',
            'proposal'    => 'Предложение',
            'negotiation' => 'Переговоры',
            'won'         => 'Выиграна',
            'lost'        => 'Проиграна',
        ];
    @endphp

    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $deal->title }}</h1>
            <div class="flex items-center space-x-3 mt-2">
                <span class="px-3 py-1 text-sm rounded-full {{ $statusColors[$deal->status] ?? 'bg-gray-100' }}">
                    {{ $statusLabels[$deal->status] ?? $deal->status }}
                </span>
                <span class="text-gray-500 text-sm">
                    Клиент:
                    <a href="{{ route('clients.show', $deal->client) }}"
                       class="text-indigo-600 hover:underline">
                        {{ $deal->client->name }}
                    </a>
                </span>
            </div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('deals.edit', $deal) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Редактировать
            </a>
            <a href="{{ route('deals.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Назад
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Детали</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Сумма:</span>
                        <span class="ml-2 font-bold text-gray-800 text-lg">
                            {{ number_format($deal->amount, 0, '.', ' ') }} ₽
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Менеджер:</span>
                        <span class="ml-2">{{ $deal->manager->name ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Закрыть до:</span>
                        <span class="ml-2">
                            {{ $deal->expected_close_date ? $deal->expected_close_date->format('d.m.Y') : '—' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Создана:</span>
                        <span class="ml-2">{{ $deal->created_at->format('d.m.Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Быстрые действия</h2>
                <div class="space-y-2">
                    <a href="{{ route('activities.create') }}?deal_id={{ $deal->id }}"
                       class="block w-full text-center bg-indigo-50 text-indigo-600
                       px-4 py-2 rounded hover:bg-indigo-100 text-sm">
                        + Добавить активность
                    </a>
                    <a href="{{ route('tasks.create') }}?deal_id={{ $deal->id }}"
                       class="block w-full text-center bg-green-50 text-green-600
                       px-4 py-2 rounded hover:bg-green-100 text-sm">
                        + Добавить задачу
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-2 space-y-6">

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">
                    История активностей ({{ $deal->activities->count() }})
                </h2>

                @forelse($deal->activities as $activity)
                    <div class="border-l-4
                        {{ $activity->type === 'call' ? 'border-blue-400' : '' }}
                        {{ $activity->type === 'email' ? 'border-purple-400' : '' }}
                        {{ $activity->type === 'meeting' ? 'border-green-400' : '' }}
                        {{ $activity->type === 'note' ? 'border-gray-400' : '' }}
                        pl-4 py-2 mb-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-medium uppercase text-gray-500">
                                    {{ $activity->type }}
                                </span>
                                <p class="text-gray-700 text-sm mt-1">
                                    {{ $activity->description }}
                                </p>
                                <p class="text-gray-400 text-xs mt-1">
                                    {{ $activity->user->name ?? '—' }} •
                                    {{ $activity->created_at->format('d.m.Y H:i') }}
                                </p>
                            </div>
                            <form method="POST"
                                  action="{{ route('activities.destroy', $activity) }}"
                                  onsubmit="return confirm('Удалить?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 text-xs">
                                    ✕
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Активностей пока нет</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">
                    Задачи ({{ $deal->tasks->count() }})
                </h2>

                @forelse($deal->tasks as $task)
                    <div class="flex justify-between items-center
                                border border-gray-200 rounded p-3 mb-2 hover:bg-gray-50">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}"
                               class="text-indigo-600 hover:underline font-medium text-sm">
                                {{ $task->title }}
                            </a>
                            <p class="text-gray-400 text-xs mt-1">
                                Назначено: {{ $task->assignedUser->name ?? '—' }}
                                @if($task->due_date)
                                    • До: {{ $task->due_date->format('d.m.Y') }}
                                @endif
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ $task->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Задач пока нет</p>
                @endforelse
            </div>

        </div>
    </div>

@endsection
```

---

## 🎉 Все Deals Views готовы!

Теперь открой в браузере:
```
http://localhost/deals
