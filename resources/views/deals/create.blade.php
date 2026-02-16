@extends('layouts.app')

@section('title', 'Новая сделка')

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Новая сделка</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('deals.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Название <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
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
                            focus:outline-none focus:ring-2 focus:ring-indigo-500
                            @error('client_id') border-red-500 @enderror">
                        <option value="">Выберите клиента</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                                {{ $client->company ? '(' . $client->company . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Менеджер <span class="text-red-500">*</span>
                    </label>
                    <select name="manager_id"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500
                            @error('manager_id') border-red-500 @enderror">
                        <option value="">Выберите менеджера</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}"
                                {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Сумма (₽) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="amount"
                           value="{{ old('amount') }}"
                           min="0"
                           step="0.01"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           @error('amount') border-red-500 @enderror">
                    @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Статус <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>Новая</option>
                        <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Контакт</option>
                        <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Квалифицирован</option>
                        <option value="proposal" {{ old('status') == 'proposal' ? 'selected' : '' }}>Предложение</option>
                        <option value="negotiation" {{ old('status') == 'negotiation' ? 'selected' : '' }}>Переговоры</option>
                        <option value="won" {{ old('status') == 'won' ? 'selected' : '' }}>Выиграна</option>
                        <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Проиграна</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Ожидаемая дата закрытия
                    </label>
                    <input type="date"
                           name="expected_close_date"
                           value="{{ old('expected_close_date') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Создать сделку
                    </button>
                    <a href="{{ route('deals.index') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Отмена
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
