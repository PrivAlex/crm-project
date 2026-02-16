@extends('layouts.app')

@section('title', 'Сделки')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Сделки</h1>
        <a href="{{ route('deals.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Новая сделка
        </a>
    </div>

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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Клиент</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Менеджер</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Закрыть до</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($deals as $deal)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="{{ route('deals.show', $deal) }}"
                           class="text-indigo-600 hover:underline font-medium">
                            {{ $deal->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <a href="{{ route('clients.show', $deal->client) }}"
                           class="hover:underline">
                            {{ $deal->client->name ?? '—' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $deal->manager->name ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-gray-700 font-medium">
                        {{ number_format($deal->amount, 0, '.', ' ') }} ₽
                    </td>
                    <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$deal->status] ?? 'bg-gray-100' }}">
                                {{ $statusLabels[$deal->status] ?? $deal->status }}
                            </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $deal->expected_close_date ? $deal->expected_close_date->format('d.m.Y') : '—' }}
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('deals.edit', $deal) }}"
                           class="text-yellow-600 hover:underline text-sm">
                            Изменить
                        </a>
                        <form method="POST"
                              action="{{ route('deals.destroy', $deal) }}"
                              class="inline"
                              onsubmit="return confirm('Удалить сделку?')">
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
                    <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                        Сделок пока нет
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $deals->links() }}
    </div>

@endsection
