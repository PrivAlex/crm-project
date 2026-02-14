<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

{{-- Навигация --}}
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Лого + Меню --}}
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="text-xl font-bold text-indigo-600">
                    CRM
                </a>

                <a href="{{ route('clients.index') }}"
                   class="text-gray-600 hover:text-indigo-600 font-medium
                       {{ request()->routeIs('clients.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Клиенты
                </a>

                <a href="{{ route('deals.index') }}"
                   class="text-gray-600 hover:text-indigo-600 font-medium
                       {{ request()->routeIs('deals.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Сделки
                </a>

                <a href="{{ route('tasks.index') }}"
                   class="text-gray-600 hover:text-indigo-600 font-medium
                       {{ request()->routeIs('tasks.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">
                    Задачи
                </a>
            </div>

            {{-- Пользователь --}}
            <div class="flex items-center space-x-4">
                    <span class="text-gray-600 text-sm">
                        {{ auth()->user()->name }}
                    </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm text-gray-500 hover:text-red-500">
                        Выйти
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

{{-- Флеш сообщения --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

{{-- Контент --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
</main>

</body>
</html>
