@extends('layouts.app')

@section('title', 'Новая задача')

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Новая задача</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Название <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="Что нужно сделать?"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           @error('title') border-red-500 @enderror">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Описание
                    </label>
                    <textarea name="description"
                              rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Связанная сделка
                    </label>
                    <select name="deal_id"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Без сделки</option>
                        @foreach($deals as $deal)
                            <option value="{{ $deal->id }}"
                                {{ old('deal_id', $selectedDeal?->id) == $deal->id ? 'selected' : '' }}>
                                {{ $deal->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Назначить <span class="text-red-500">*</span>
                    </label>
                    <select name="assigned_to"
                            class="w-full border border-gray-300 rounded px-3 py-2
                            focus:outline-none focus:ring-2 focus:ring-indigo-500
                            @error('assigned_to') border-red-500 @enderror">
                        <option value="">Выберите сотрудника</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
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
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                            Ожидает
                        </option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                            В работе
                        </option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Завершена
                        </option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Срок выполнения
                    </label>
                    <input type="date"
                           name="due_date"
                           value="{{ old('due_date') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Создать задачу
                    </button>
                    <a href="{{ route('tasks.index') }}"
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Отмена
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
