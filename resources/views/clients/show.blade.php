@extends('layouts.app')

@section('title', $client->name)

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $client->name }}</h1>
            @if($client->company)
                <p class="text-gray-500">{{ $client->company }}</p>
            @endif
        </div>
        <div class="space-x-2">
            <a href="{{ route('clients.edit', $client) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Редактировать
            </a>
            <a href="{{ route('clients.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Назад
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- Информация о клиенте --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Контакты</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-gray-500">Email:</span>
                    <span class="ml-2">{{ $client->email ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Телефон:</span>
                    <span class="ml-2">{{ $client->phone ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Менеджер:</span>
                    <span class="ml-2">{{ $client->manager->name ?? '—' }}</span>
                </div>
            </div>
            @if($client->notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-gray-500 text-sm">Заметки:</p>
                    <p class="text-gray-700 text-sm mt-1">{{ $client->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Сделки клиента --}}
        <div class="col-span-2 bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">
                    Сделки ({{ $client->deals->count() }})
                </h2>
                <a href="{{ route('deals.create') }}?client_id={{ $client->id }}"
                   class="text-sm bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                    + Сделка
                </a>
            </div>

            @forelse($client->deals as $deal)
                <div class="border border-gray-200 rounded p-3 mb-2 hover:bg-gray-50">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('deals.show', $deal) }}"
                           class="text-indigo-600 hover:underline font-medium">
                            {{ $deal->title }}
                        </a>
                        <div class="flex items-center space-x-3">
                            <span class="text-gray-700 font-medium">
                                {{ number_format($deal->amount, 0, '.', ' ') }} ₽
                            </span>
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $deal->status === 'won' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $deal->status === 'lost' ? 'bg-red-100 text-red-700' : '' }}
                                {{ !in_array($deal->status, ['won', 'lost']) ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $deal->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Сделок пока нет</p>
            @endforelse
        </div>

    </div>

@endsection
