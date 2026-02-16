@extends('layouts.app')

@section('title', 'Новая активность')

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Новая активность</h1>
        <p class="text-gray-500 mb-6">
            Сделка:
            <a href="{{ route('deals.show', $deal) }}"
               class="text-indigo-600 hover:underline">
                {{ $deal->title }}
            </a>
        </p>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('activities.store') }}">
                @csrf

                <input type="hidden" name="deal_id" value="{{ $deal->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Тип <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach(['call' => '📞 Звонок', 'email' => '✉️ Email', 'meeting' => '🤝 Встреча', 'note' => '📝 Заметка'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="type"
                                       value="{{ $value }}"
                                       class="sr-only peer"
                                    {{ old('type') == $value ? 'checked' : '' }}>
                                <div class="text-center border-2 border-gray-200 rounded-lg p-3
                                            peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                            hover:border-indigo-300 transition-colors">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $label }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Описание <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description"
                              rows="4"
                              placeholder="Что произошло? Что обсудили? Какой результат?"
                              class="w-full border border-gray-300 rounded px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                              @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
