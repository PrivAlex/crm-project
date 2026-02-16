@extends('layouts.app')

@section('title', 'Редактировать сделку')

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Редактировать: {{ $deal->title }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('deals.update', $deal) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Название <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $deal->title) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           @error('title') border-red-500 @enderror">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Клиент <span class="text-red-500">*</span>
                    </label>
                    <select name="client_id"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $deal->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Менеджер <span class="text-red-500">*</span>
                    </label>
                    <select name="manager_id"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}"
                                {{ old('manager_id', $deal->manager_id) == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Сумма (₽) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="amount"
                           value="{{ old('amount', $deal->amount) }}"
                           min="0"
                           step="0.01"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                @php
                    $statusLabels = [
                        'new'         => 'Новая',
                        'contacted'   => 'Контакт',
                        'qualified'   => 'Квалифицирован',
                        'proposal'    => 'Предложение',
                        'negotiation' => 'Переговоры',
                        'won'         => 'Выиграна',
                        'lost'        => 'Проиграна',
                    ];
                    $availableStatuses = array_merge(
                        [$deal->status],
                        $deal->getAllowedTransitions()
                    );
                @endphp

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Статус <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($availableStatuses as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $deal->status) == $status ? 'selected' : '' }}>
                                {{ $statusLabels[$status] ?? $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Ожидаемая дата закрытия
                    </label>
                    <input type="date"
                           name="expected_close_date"
                           value="{{ old('expected_close_date', $deal->expected_close_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Сохранить
                    </button>
                    <a href="{{ route('deals.show', $deal) }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Отмена
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
