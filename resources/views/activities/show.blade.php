@extends('layouts.app')

@section('title', 'Активность')

@section('content')

    @php
        $typeLabels = [
            'call'    => '📞 Звонок',
            'email'   => '✉️ Email',
            'meeting' => '🤝 Встреча',
            'note'    => '📝 Заметка',
        ];
        $typeColors = [
            'call'    => 'bg-blue-100 text-blue-700',
            'email'   => 'bg-purple-100 text-purple-700',
            'meeting' => 'bg-green-100 text-green-700',
            'note'    => 'bg-gray-100 text-gray-700',
        ];
    @endphp

    <div class="max-w-2xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Активность</h1>
            <a href="{{ route('deals.show', $activity->deal) }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                ← К сделке
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">

            <div class="flex items-center space-x-3 mb-4">
                <span class="px-3 py-1 rounded-full text-sm font-medium
                             {{ $typeColors[$activity->type] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $typeLabels[$activity->type] ?? $activity->type }}
                </span>
                <span class="text-gray-400 text-sm">
                    {{ $activity->created_at->format('d.m.Y H:i') }}
                </span>
            </div>

            <div class="mb-6">
                <p class="text-gray-700 leading-relaxed">
                    {{ $activity->description }}
                </p>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                <div>
                    <span class="text-gray-500">Сделка:</span>
                    <a href="{{ route('deals.show', $activity->deal) }}"
                       class="ml-2 text-indigo-600 hover:underline">
                        {{ $activity->deal->title ?? '—' }}
                    </a>
                </div>
                <div>
                    <span class="text-gray-500">Автор:</span>
                    <span class="ml-2 text-gray-700">
                        {{ $activity->user->name ?? '—' }}
                    </span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <form method="POST"
                      action="{{ route('activities.destroy', $activity) }}"
                      onsubmit="return confirm('Удалить активность?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:underline text-sm">
                        Удалить активность
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection
