@extends('layouts.app')

@section('title', 'Клиенты')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Клиенты</h1>
        <a href="{{ route('clients.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Добавить клиента
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Имя</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Компания</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Телефон</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Менеджер</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <a href="{{ route('clients.show', $client) }}"
                           class="text-indigo-600 hover:underline font-medium">
                            {{ $client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $client->company ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $client->email ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $client->phone ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $client->manager->name ?? '—' }}
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('clients.edit', $client) }}"
                           class="text-yellow-600 hover:underline text-sm">
                            Изменить
                        </a>
                        <form method="POST"
                              action="{{ route('clients.destroy', $client) }}"
                              class="inline"
                              onsubmit="return confirm('Удалить клиента?')">
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
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        Клиентов пока нет
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>

@endsection
